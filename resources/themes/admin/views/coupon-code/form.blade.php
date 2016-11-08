@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Code', 'h1_href'=>route('admin.cpcode.index'), 'h1_small'=> $isNewRecord ? 'Create new coupon code' : 'Edit coupon code']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $isNewRecord ? "New Coupon Code" : "Edit Coupon Code" }}</h3>
        </div>
        <div class="box-body">
            @if ($isNewRecord)
                {{ Form::open(['route' => 'admin.cpcode.store', 'files' => true]) }}
            @else
                {{ Form::model($cpcode, ['method' => 'PATCH', 'route' => ['admin.cpcode.update', $cpcode->id], 'files' => true]) }}
            @endif

            <div class="form-group{{ $errors->has('code') ? ' has-error' : '' }}">
                {{ Form::label('code', 'Code') }}
                {{ Form::text('code', $cpcode->code, ['class' => 'form-control'])}}
                @if($errors->has('code'))
                    <span class="help-block">
                        <strong>{{ $errors->first('code') }}</strong>
                    </span>
                @endif
            </div>

            <div class="form-group">
                {{ Form::label('cp_event_id', 'Event') }}
                {{ Form::select('cp_event_id',$events, $cpcode->cp_event_id, ['class' => 'form-control'])}}
            </div>

            <div class="form-group">
                {{ Form::label('status', 'Status') }}
                {{ Form::select('status', \App\Models\Backend\CmsShow::statusLabel(), $cpcode->status, ['class' => 'form-control'])}}
            </div>

            <div class="form-group{{ $errors->has('limit') ? ' has-error' : '' }}">
                {{ Form::label('limit', 'Limit') }}
                {{ Form::text('limit', $cpcode->limit, ['class' => 'form-control'])}}
                @if($errors->has('limit'))
                    <span class="help-block">
                    <strong>{{ $errors->first('limit') }}</strong>
                </span>
                @endif
            </div>

            <div class="form-group{{ $errors->has('amount') ? ' has-error' : '' }}">
                {{ Form::label('amount', 'Amount') }}
                {{ Form::text('amount', $cpcode->amount, ['class' => 'form-control'])}}
                @if($errors->has('amount'))
                    <span class="help-block">
                    <strong>{{ $errors->first('amount') }}</strong>
                </span>
                @endif
            </div>

                <div class="form-group">
                    {{ Form::label('amount_type', 'Amount Type') }}
                    {{ Form::select('amount_type', \App\Models\Backend\CpCode::getAmountTypes(), $cpcode->amount_type, ['class' => 'form-control'])}}
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