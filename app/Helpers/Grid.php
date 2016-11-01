<?php
namespace App\Helpers;

use Illuminate\Support\HtmlString;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class Grid {
	
	private $columns;
	private $query;
	private $perPage = 20;
	private $magicMethodPrefix = 'get_';
	private $class;
	private $filters;
	private $ajax = true;
	private $action = true;
	private $actionButtons = [];
	private $hiddenColumns = [];
	private $from = '';
	
	public function __construct($query, $columns = false) {
		$this->query = $query;
		
		if(stripos($this->query->from, ' as ') !== FALSE) {
			$parts = explode(' ', $this->query->from);
			$this->from = end($parts);
		} else {
			$this->from = $this->query->from;
		}
		
		$this->filters = [
			'simple' => [function($column, $config, $input) {
				$default = isset($input[$column]) ? $input[$column] : null;
				
				return \Form::text($column, $default, ['class' => 'simple-filter', 'id' => "simple-filter-$column"]);
			}, function($column, $config, $query, $input){
				if(!empty($input[$column])) {
					$query->where($config['where'], $input[$column]);
				}
			}],
			'like' => [function($column, $config, $input) {
				$default = isset($input[$column]) ? $input[$column] : null;
				
				return \Form::text($column, $default, ['class' => 'like-filter', 'id' => "like-filter-$column"]);
			}, function($column, $config, $query, $input){
				if(!empty($input[$column])) {
					$query->where($config['where'], 'LIKE', "%$input[$column]%");
				}
			}],
			'dropdown' => [function($column, $config, $input) {
				$default = isset($input[$column]) ? $input[$column] : null;
				
				return \Form::select($column, $config['filter'], $default, ['placeholder' => 'Tất cả', 'class' => 'dropdown-filter', 'id' => "dropdown-filter-$column"]);
			}, function($column, $config, $query, $input){
				if(isset($input[$column]) && $input[$column] != '') {
					$query->where($config['where'], $input[$column]);
				}
			}],
			'yesno' => [function($column, $config, $input) {
				$default = isset($input[$column]) ? $input[$column] : null;
				
				return \Form::select($column, [1 => 'Có', 2 => 'Không'], $default, ['placeholder' => 'Tất cả', 'class' => 'yesno-filter', 'id' => "yesno-filter-$column"]);
			}, function($column, $config, $query, $input){
				if(!empty($input[$column])) {
					if($input[$column] == 1) {
						$query->whereNotNull($config['where']);
					} else {
						$query->whereNull($config['where']);
					}
				}
			}]
		];
		
		if($columns) {
			$this->columns($columns);
		}
	}
	
	public function __call($method, $arguments) {
		if(starts_with($method, $this->magicMethodPrefix)) {
			$key = str_replace($this->magicMethodPrefix, '', $method);
			
			if(isset($this->columns[$key]['format'])) {
				return $this->columns[$key]['format']($arguments[0]);
			} else {
				return $arguments[1];
			}
		}
	}
	
	public function ajax($boolean) {
		$this->ajax = $boolean;
	}
	
	public function setFilter($k, $filterHtml, $filterQuery) {
		$this->filters[$k] = [$filterHtml, $filterQuery];
	}
	
	public function setHiddenColumn($mixed) {
		if(is_array($mixed)) {
			$this->hiddenColumns = array_merge($this->hiddenColumns, $mixed);
		} else {
			$this->hiddenColumns[] = $mixed;
		}
	}
	
	public function removeActionColumn() {
		$this->action = false;
	}
	
	public function getLabels() {
		$columns = $this->getShowColumns();
		$sort = Input::get('sort');
		
		$labels = [];
		
		foreach ($columns as $k => $config) {
			$labels[$k] = $config['label'];
		}
		
		return $labels;
	}
	
	public function getFilteredQuery($params = null) {
		$columns = $this->getShowColumns();
		$query = $this->query;
		
		if($params === null) {
			$params = Input::except('page');
		}
			
		$fields = $this->parseFields($columns);
		$query->select($fields['db']);
		
		foreach ($columns as $k => $config) {
			if($filter = $config['filter']) {
				if(is_string($filter)) {
					$filter = $this->filters[$filter];
				} else {
					if(is_string(current($filter))) {
						$filter = $this->filters['dropdown'];
					}
				}
				
				$column = str_replace('.', '_', $k);
		
				$filter[1]($column, $config, $query, $params);
			}
		}
		
		return $query;
	}
	
	public function table() {
		if($this->action) {
			$this->column('action', [
				'custom' => true,
				'format' => function($item) {
					$uri = \Request::route()->getUri();
					$show = link_to(url("$uri/show", [$item->id]), '', ['class' => 'glyphicon glyphicon-eye-open', 'data-toggle' => 'tooltip', 'data-original-title' => 'View']);
					$edit = link_to(url("$uri/edit", [$item->id]), '', ['class' => 'glyphicon glyphicon-pencil', 'data-toggle' => 'tooltip', 'data-original-title' => 'Edit']);
					$delete = link_to(url("$uri/delete", [$item->id]), '', ['class' => 'glyphicon glyphicon-trash glyphicon-last-child', 'data-toggle' => 'tooltip', 'data-original-title' => 'Delete']);
					
					return $show.$edit.$delete;
				}
			]);
		}
		
		$columns = $this->getShowColumns();

		if(empty($columns)) {
			$columns = $this->columns;
		}
		
		$query = $this->query;
		$fields = $this->parseFields($columns);
		
		$query->select(array_merge($this->hiddenColumns, $fields['db']));
		
		$params = Input::except('page');
		$sort = Input::get('sort');
		$labels = [];
		$filters = [];
		
		foreach ($columns as $k => $config) {
			$desc = "-$k";
			$lk = ($sort == $desc) ? $k : $desc;
			
			$labels[$lk] = [
				'k' => "column-" . str_replace(['.', '_'], '-', $k),
				'label' => $config['label'],
				'sortable' => $config['sortable'],
				'class' => ($sort == $k) ? 'sort asc' : (($sort == $desc) ? 'sort desc' : '')
			];
			
			if($filter = $config['filter']) {
				if(is_string($filter)) {
					$filter = $this->filters[$filter];
				} else {
					if(is_string(current($filter))) {
						$filter = $this->filters['dropdown'];
					}
				}
				
				$column = str_replace('.', '_', $k);
				
				$filters[$k] = $filter[0]($column, $config, $params);
				$filter[1]($column, $config, $query, $params);
			} else {
				$filters[$k] = '';
			}
		}
		
		if($sort) {
			$sortOrder = starts_with($sort, '-') ? 'desc' : 'asc';
			$sort = preg_replace('/\-/', '', $params['sort'], 1);
			$query->orders = [];
			$query->orderBy($sort, $sortOrder);
		}
		
		$items = $this->query->paginate($this->perPage);

		if($fields['custom']) {
			foreach ($items as &$item) {
				foreach ($fields['custom'] as $k => $custom) {
					$item->$k = null;
				}
			}
		}
		
		$offsetStart = ($items->currentPage() - 1) * $items->perPage();
		$start = $offsetStart + 1;
		$end = $offsetStart + $items->count();
		
		return view('widgets.grid', [
			'actionButtons' => $this->actionButtons,
			'items' => $items,
			'grid' => $this,
			'labels' => $labels,
			'params' => $params,
			'class' => $this->class,
			'start' => $start,
			'end' => $end,
			'total' => $items->total(),
			'sort' => $sort,
			'columns' => $this->columns,
			'totalColumns' => count($this->columns),
			'route' => \Request::route()->getName(),
			'showColumns' => array_keys($columns),
			'filters' => $filters,
			'ajax' => $this->ajax
		]);
	}
	
	public function addButton($html) {
		$this->actionButtons[] = $html;
	}
	
	public function column($key, $config = []) {		
		if(is_string($config)) {
			$config = ['label' => $config];
		}
		
		if(!isset($config['custom'])) {
			$config['custom'] = false;
		}
		
		if(!isset($config['filter'])) {
			$config['filter'] = $config['custom'] ? false : 'simple';
		}

		if(!$config['custom']) {
			if(isset($config['field'])) {
				$config['where'] = DB::raw($config['field']);
				$config['field'] = DB::raw("({$config['field']}) `$key`");
			} else {
				if(($pos = stripos($key, ' as ')) !== FALSE) {
					$config['field'] = $key;
					$config['where'] = substr($key, 0, $pos);
					$key = substr($key, $pos + 4);
				} else {
					if((strpos($key, '.') === FALSE)) {
						$config['field'] = $config['where'] = "{$this->from}.$key";
					} else {
						$config['where'] = $key;
						$config['field'] = "$key AS $key";
					}
				}
			}
		}
		
		if(!isset($config['label'])) {
			$config['label'] = ($key == 'id') ? 'ID' : title_case(str_replace(['_', '.'], ' ', $key));
		}
		
		if($config['custom']) {
			$config['sortable'] = false;
		} else if(!isset($config['sortable'])) {
			$config['sortable'] = true;
		}

		$this->columns[$key] = $config;
	}
	
	public function columns($columns) {
		foreach ($columns as $key => $config) {
			if(is_string($config) && !is_string($key)) {
				$this->column($config);
			} else {
				$this->column($key, $config);
			}
		}
	}
	
	public function setPerPage($perPage) {
		$this->perPage = $perPage;
	}
	
	public function setGridClass($class) {
		$this->class .= ' ' . $class;
	}
	
	private function parseFields($columns) {
		$fields = ['db' => [], 'custom' => []];
		
		foreach ($this->columns as $k => $column) {
			if($column['custom']) {
				$fields['custom'][$k] = $column['format'];
			} else {
				$fields['db'][$k] = $column['field'];
			}
		}
		
		return $fields;
	}
	
	private function getShowColumns() {
		$excludeColumns = isset($_COOKIE['columns']) ? json_decode($_COOKIE['columns']) : [];
		$columns = [];
		
		foreach ($this->columns as $k => $column) {
			if(!in_array($k, $excludeColumns)) {
				$columns[$k] = $column;
			}
		}
		
		return $columns;
	}
}