<div id="grid-loading"><img src="{!! asset('images/loading.gif') !!}" /></div>
<div class="grid-wrap">
	<form class="grid-form" method="get" action="{{ route($route) }}" autocomplete="off">
		@yield('filter')
		<div class="grid-head clearfix">
			<div id="grid-actions">
				<div class="grid-action has-popup">
					<button class="btn btn-grid grid-popup-button" type="button">
						<span class="glyphicon glyphicon-eye-open"></span>
						<span>Columns</span>
						<span class="caret"></span>
					</button>
					<div class="grid-popup-wrap">
						<div class="arrow"></div>
						<div class="grid-popup-content">
							<div class="toggle-columns">
								<table>
								<?php $count = 1; ?>
								@foreach ($columns as $k => $column)
									@if(($count - 1) % 4 == 0)
									<tr>
									@endif
									<td><label class="cb"><input {{ in_array($k, $showColumns) ? 'checked="checked" ' : ''  }}type="checkbox" data-name="{{ $k }}" value="1" /><span>{{ $column['label'] }}</span></label></td>
									@if($count % 4 == 0 || $count == $totalColumns)
									</tr>
									@endif
									<?php $count++; ?>
								@endforeach
								</table>
								<a href="{{ route($route, Input::all()) }}" class="btn btn-primary apply-toogle-columns">OK</a>
							</div>
						</div>
					</div>
				</div>
				<div class="grid-action">
					<a href="{{ route($route) }}" class="btn btn-primary reset-filter">Reset Filter</a>
				</div>
				@foreach ($actionButtons as $actionButton)
					{!! $actionButton !!}
				@endforeach
				@yield('grid')
			</div>
		</div>

		<div class="grid-horizontal-scroll">
			@if($total)<div class="grid-counter">{{ $start }} - {{ $end }} of <span>{{ $total }}</span></div>@endif
			<table class="grid{{ $class }}" data-ajax="{{ $ajax }}">
				<thead>
					<tr class="grid-title">
					@foreach ($labels as $k => $l)
						@if($l['sortable'])
							@if($l['class'])<th class="{{ $l['k'] }} {{ $l['class'] }}">@else<th class="{{ $l['k'] }}">@endif<a data-sort="{{ $k }}" href="{{ route($route, array_merge($params, ['sort' => $k])) }}">{{ $l['label'] }}</a></th>
						@else
							<th class="{{ $l['k'] }}">{{ $l['label'] }}</th>
						@endif
					@endforeach
					</tr>
					<tr class="grid-filter">
					@foreach ($filters as $k => $filter)
						<td>{!! $filter !!}</td>
					@endforeach
					</tr>
				</thead>
				<tbody class="grid-body">
					@foreach ($items as $item)
						<tr>
							@foreach ($showColumns as $k)
							<td>{!! $grid->{"get_$k"}($item, $item->$k) !!}</td>
							@endforeach
						</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		{{ $items->appends($params)->links() }}
		<input type="text" style="display: none;" />
		<input type="hidden" name="sort" value="{{ Input::get('sort') }}" />
	</form>
</div>
@push('styles')
	<link rel="stylesheet" href="{!! asset('css/grid.css') !!}">
@endpush
@push('scripts')
	<script src="{!! asset('js/grid.js') !!}"></script>
	<script type="text/javascript">
		var grid = {
			callbacks: [],
			init: function(fn) {
				this.callbacks.push(fn);
			}
		};
	</script>
@endpush