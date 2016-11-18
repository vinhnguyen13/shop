@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Category', 'h1_href'=>route('admin.category.index'), 'h1_small'=>'Category Management']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Detail</h3>
            <a href="{{ route('admin.category.edit', ['id' => $model->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label(null, 'Name') }}
                <div>{{ $model->name }}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Description') }}
                <div>{!! $model->description !!}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Status') }}
                <div>{{ \App\Helpers\AppHelper::statusLabel($model->status) }}</div>
            </div>

        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

