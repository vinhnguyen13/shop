@extends('layouts.app')
<?php
$isNewRecord = !empty($model->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product Size', 'h1_href'=>route('admin.productSize.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> Product Size</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.manufacturer.store', 'files' => true]) }}
            {{ Form::hidden('id', $model->id) }}
            <div class="form-group">
                {{ Form::label(null, 'Name') }}
                {{ Form::text('name', $model->name,['class' => 'form-control'])}}
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Order') }}
                {{ Form::text('order', $model->order,['class' => 'form-control'])}}
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
