@extends('layouts.app')
<?php
$isNewRecord = !empty($model->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Category', 'h1_href'=>route('admin.category.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> Category</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.category.store', 'files' => true]) }}
                {{ Form::hidden('id', $model->id) }}

                <?php
                $categories = \App\Models\ShopCategory::where(['status'=>true, 'parent_id'=>0])->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
                $categoriesSelected = app(\App\Models\Backend\ShopCategory::class)->getCategoriesToForm();
                ?>
                <div class="form-group">
                    {{ Form::label(null, 'Parent') }}
                    {!! Form::select('parent[]', $categories, $categoriesSelected, ['class' => 'form-control category-list', 'multiple'=>'multiple', 'style'=>'width: 100%;']) !!}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Name') }}
                    {{ Form::text('name', $model->name,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Description') }}
                    {{ Form::textarea('description', $model->description,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Image') }}
                    {{ Form::file('image', ['url' => route('admin.upload', ['type'=>\App\Services\UploadMedia::UPLOAD_CATEGORY]), 'files' => !empty($image) ? $image : null, 'clientOptions' => ['singleFileUploads' => 1, 'limitMultiFileUploadSize' => 1, 'maxNumberOfFiles' => 1] ]) }}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Status') }}
                    {{ Form::select('status', \App\Helpers\AppHelper::statusLabel(), $model->status,['class' => 'form-control'])}}
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


@push('styles')
<link rel="stylesheet" href="/themes/admin/plugins/select2/select2.min.css">
@endpush


@push('scripts')
    <script src="/themes/admin/plugins/select2/select2.js"></script>
    <script type="text/javascript">
        $( ".category-list" ).select2();
    </script>
@endpush