@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Shipper', 'h1_href'=>route('admin.shipper.index'), 'h1_small'=>'Shipper Management']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Detail</h3>
            <a href="{{ route('admin.shipper.edit', ['id' => $model->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label(null, 'Firstname') }}
                <div>{{ $model->firstname }}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Lastname') }}
                <div>{{ $model->lastname }}</div>
            </div>

        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

