@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Manufacturer', 'h1_href'=>route('admin.manufacturer.index'), 'h1_small'=>'Manufacturer Management']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Detail</h3>
            <a href="{{ route('admin.manufacturer.edit', ['id' => $model->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                <div>{{ $model->name }}</div>
            </div>
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

