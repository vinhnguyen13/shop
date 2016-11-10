@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Event', 'h1_href'=>route('admin.cpevent.index'), 'h1_small'=>'Coupon Event detail']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Coupon Event Detail</h3>
            <a href="{{ route('admin.cpevent.edit', ['id' => $cpevent->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">

            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                <div>{{ $cpevent->name }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                <div>{{ $cpevent->description }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('start_date', 'Start Date') }}
                <div>{{ date('d-m-Y', $cpevent->start_date) }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('end_date', 'End Date') }}
                <div>{{ date('d-m-Y', $cpevent->end_date) }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('type', 'Type') }}
                <div>{{ \App\Models\Backend\CpEvent::getTypes($cpevent->type) }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('status', 'Status') }}
                <div>{{ \App\Helpers\AppHelper::statusLabel($cpevent->status) }}</div>
            </div>

        </div>
    </div>
@endsection

