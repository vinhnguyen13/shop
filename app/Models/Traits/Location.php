<?php
namespace App\Models\Traits;

use DB;
use App\Models\SlugSearch;
use App\Models\AdProduct;
use App\Models\AdDistrict;
use App\Models\AdCity;
use App\Helpers\Elastic;

trait Location
{
	protected static function registerEvents() {
		static::creating(function($model) {
			$model->slug = $model->buildSlug();
	    });
		
		static::updating(function($model) {
			$dirty = $model->getDirty();
			
			if(isset($dirty['name'])) {
				$slug = $model->buildSlug();
				
				if($slug != $model->slug) {
					$model->slug = $slug;
				}
			}
		});
		
		static::created(function($model) {
			 $slug = new SlugSearch();
			 $slug->slug = $model->slug;
			 $slug->table = $model->table;
			 $slug->value = $model->id;
			 $slug->save();
			 
			 $model->insertEs();
		});
		
		static::updated(function($model) {
			$dirty = $model->getDirty();
			
			if(isset($dirty['slug'])) {
				SlugSearch::where('table', $model->table)->where('value', $model->id)->update(['slug' => $model->slug]);
			}
			 
			$model->updateEs();
		});
		
		static::deleted(function($model) {
			SlugSearch::where('table', $model->table)->where('value', $model->id)->delete();
			 
			$model->removeEs();
		});
	}
	
	public function insertEs() {
		$cityDoc = AdCity::buildDocument($this->city);
		$districtDoc = AdDistrict::buildDocument($this->district, $cityDoc);
		
		$doc = self::buildDocument($this, $districtDoc, $cityDoc);
		$doc[AdProduct::ELASTIC_TOTAL_SELL] = 0;
		$doc[AdProduct::ELASTIC_TOTAL_RENT] = 0;
		
		$type = ($this->table == 'ad_building_project') ? 'project_building' : str_replace('ad_', '', $this->table);
		
		Elastic::bulk(config('elastic.index.location'), $type, [['create' => ['_id' => $this->id]], $doc]);
	}
	
	public function updateEs() {
		$cityDoc = AdCity::buildDocument($this->city);
		$districtDoc = AdDistrict::buildDocument($this->district, $cityDoc);
		
		$doc = self::buildDocument($this, $districtDoc, $cityDoc);
		
		$type = ($this->table == 'ad_building_project') ? 'project_building' : str_replace('ad_', '', $this->table);
		
		dump(Elastic::bulk(config('elastic.index.location'), $type, [['update' => ['_id' => $this->id]], ['doc' => $doc]]));
	}
	
	public function removeEs() {
		$type = ($this->table == 'ad_building_project') ? 'project_building' : str_replace('ad_', '', $this->table);
		
		Elastic::bulk(config('elastic.index.location'), $type, [['delete' => ['_id' => $this->id]]]);
	}
	
	public function getTotalSellAttribute() {
		return $this->getTotal(AdProduct::TYPE_FOR_SELL);
	}
	
	public function getTotalRentAttribute() {
		return $this->getTotal(AdProduct::TYPE_FOR_RENT);
	}
	
	private function getTotal($type) {
		$id = ($this->table == 'ad_building_project') ? 'project_building_id' : str_replace('ad_', '', $this->table) . '_id';
		
		$query = DB::table('ad_product')->select([DB::raw("COUNT(*) AS `total`")])->where($id, $this->id)->where('type', $type);
		
		foreach (AdProduct::$onCondition as $k => $v) {
			$query->where($k, $v);
		}
		
		return $query->first()->total;
	}
	
	public function buildSlug() {
		return SlugSearch::uniqid(str_slug("{$this->city->name} {$this->district->name} {$this->name}"));
	}
}

