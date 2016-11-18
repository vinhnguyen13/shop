@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product', 'h1_href'=>route('admin.product.index'), 'h1_small'=>'Product Management']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Detail</h3>
            <a href="{{ route('admin.product.edit', ['id' => $model->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('name', 'Name') }}
                <div>{{ $model->name }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('description', 'Description') }}
                <div>{!! $model->description !!}</div>
            </div>

            <div class="form-group">
                {{ Form::label('status', 'Status') }}
                <div>{{ \App\Helpers\AppHelper::statusLabel($model->status) }}</div>
            </div>

        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

