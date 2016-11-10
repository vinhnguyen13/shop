@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Event', 'h1_href'=>route('admin.cpevent.index'), 'h1_small'=> $isNewRecord ? 'Create new coupon event' : 'Edit coupon event']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $isNewRecord ? "New Coupon Event" : "Edit Coupon Event" }}</h3>
        </div>
        <div class="box-body">
            @if ($isNewRecord)
                {{ Form::open(['route' => 'admin.cpevent.store', 'files' => true]) }}
            @else
                {{ Form::model($cpevent, ['method' => 'PATCH', 'route' => ['admin.cpevent.update', $cpevent->id], 'files' => true]) }}
            @endif

            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                {{ Form::label('name', 'Name') }}
                {{ Form::text('name', $cpevent->name,['class' => 'form-control'])}}
                @if($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                {{ Form::textarea('description', $cpevent->description, ['class'=>'form-control']) }}
            </div>

            <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                {{ Form::label('start_date', 'Start Date') }}
                {{ Form::text('start_date', date('d-m-Y', $cpevent->start_date), ['id' => 'start_date', 'class' => 'form-control', 'readOnly' => true])}}
                @if($errors->has('start_date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('start_date') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                {{ Form::label('end_date', 'End Date') }}
                {{ Form::text('end_date', date('d-m-Y', $cpevent->end_date), ['id' => 'end_date', 'class' => 'form-control', 'readOnly' => true])}}
                @if($errors->has('end_date'))
                    <span class="help-block">
                        <strong>{{ $errors->first('end_date') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('type', 'Type') }}
                {{ Form::select('type', \App\Models\Backend\CpEvent::getTypes(), $cpevent->type, ['class' => 'form-control'])}}
            </div>

            <div class="form-group">
                {{ Form::label('status', 'Status') }}
                {{ Form::select('status', \App\Helpers\AppHelper::statusLabel(), $cpevent->status, ['class' => 'form-control'])}}
            </div>

            <div class="form-group">
                {{ Form::submit('Save', array('class' => 'btn btn-primary btn-flat')) }}
            </div>

            {{ Form::close() }}
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection
@push('styles')
    <link rel="stylesheet" href="/themes/admin/plugins/datepicker/datepicker3.css">
@endpush
@push('scripts')
    <script src="/themes/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script type="text/javascript">
	    $('#start_date').datepicker({
	        todayBtn: "linked",
	        autoclose: true,
	        todayHighlight: true,
	        format: 'dd-mm-yyyy'
	    });
	
	    $('#end_date').datepicker({
	        todayBtn: "linked",
	        autoclose: true,
	        todayHighlight: true,
	        format: 'dd-mm-yyyy'
	    });
	</script>
@endpush