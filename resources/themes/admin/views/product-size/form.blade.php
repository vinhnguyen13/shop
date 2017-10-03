@extends('layouts.app')
<?php
$isNewRecord = !empty($model->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Size', 'h1_href'=>route('admin.productSize.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> Size</h3>
        </div>
        <div class="box-body">
            @if (count($errors) > 0)
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> Alert!</h4>
                    @foreach ($errors->all() as $error)
                        <div>{{ $error }}</div>
                    @endforeach
                </div>
            @endif
            {{ Form::open(['route' => 'admin.productSize.store', 'files' => true]) }}
            {{ Form::hidden('id', $model->id) }}
            <div class="form-group">
                {{ Form::label(null, 'Category') }}
                {!! Form::select('category_id', $categories, $model->category_id, ['class' => 'form-control category-list']) !!}
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Person Type') }}
                {!! Form::select('size_person_id', $sizePersons, $model->size_person_id, ['class' => 'form-control category-list']) !!}
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Manufacturer') }}
                {!! Form::select('manufacturer_id', $manufacturers, $model->manufacturer_id, ['class' => 'form-control category-list']) !!}
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Locales') }}
                {!! Form::select('size_locales_id', $locales, $model->size_locales_id, ['class' => 'form-control category-list']) !!}
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Size Category') }}
                {!! Form::select('size_category_id', $sizeCategories, $model->size_category_id, ['class' => 'form-control category-list']) !!}
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Value') }}
                {{ Form::text('value', $model->value,['class' => 'form-control'])}}
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
