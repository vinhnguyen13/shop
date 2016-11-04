@extends('layouts.app')
<?php
$isNewRecord = !empty($model->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'User', 'h1_href'=>route('admin.user.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> User</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.user.store', 'files' => true]) }}
                <div class="form-group">
                    {{ Form::label(null, 'Username') }}
                    {{ Form::text('name', $model->name,['class' => 'form-control'])}}
                    {{ Form::hidden('id', $model->id) }}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Description') }}
                    {{ Form::textarea('description', $model->description,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Image') }}
                    {{ Form::file('avatar', ['url' => route('admin.category.index'), 'files' => !empty($image) ? $image : null, 'clientOptions' => ['singleFileUploads' => 1, 'limitMultiFileUploadSize' => 1, 'maxNumberOfFiles' => 1] ]) }}
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
