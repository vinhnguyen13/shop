@extends('layouts.app')
<?php
$isNewRecord = !empty($model->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product', 'h1_href'=>route('admin.product.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> Product</h3>
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
            {{ Form::open(['route' => 'admin.product.store', 'files' => true]) }}
                {{ Form::hidden('id', $model->id) }}

                <div class="nav-tabs-custom">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">General</a></li>
                        <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Data</a></li>
                        <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false">Detail</a></li>
                        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Links</a></li>
                        <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Discount</a></li>
                        <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Special</a></li>
                        <li class=""><a href="#tab_7" data-toggle="tab" aria-expanded="false">Image</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            @include('product._partials.form-general')
                        </div>
                        <div class="tab-pane" id="tab_2">
                            @include('product._partials.form-data')
                        </div>
                        <div class="tab-pane" id="tab_6">
                            @include('product._partials.form-detail')
                        </div>
                        <div class="tab-pane" id="tab_3">
                            @include('product._partials.form-link')
                        </div>
                        <div class="tab-pane" id="tab_4">
                            @include('product._partials.form-discount')
                        </div>
                        <div class="tab-pane" id="tab_5">
                            @include('product._partials.form-special')
                        </div>
                        <div class="tab-pane" id="tab_7">
                            <div class="form-group">
                                {{ Form::label(null, 'Image') }}
                                {{ Form::file('image', ['url' => route('admin.upload', ['type'=>\App\Services\UploadMedia::UPLOAD_PRODUCT]), 'files' => !empty($image) ? $image : null, 'clientOptions' => ['singleFileUploads' => 1, 'limitMultiFileUploadSize' => 1, 'maxNumberOfFiles' => 10] ]) }}
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-content -->
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
    <link rel="stylesheet" href="/themes/admin/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="/themes/admin/plugins/iCheck/all.css">
    <link rel="stylesheet" href="/themes/admin/plugins/select2/select2.min.css">
@endpush
@push('scripts')
    <script src="/themes/admin/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="/rofilde-ckeditor/laravel-ckeditor/ckeditor.js"></script>
    <script src="/themes/admin/plugins/iCheck/icheck.min.js"></script>
    <script src="/themes/admin/plugins/select2/select2.js"></script>
    <script type="text/javascript">
        CKEDITOR.replace( 'content' );
        CKEDITOR.config.height = 500;

        $(function() {
            $('.date').datepicker({
                autoclose: true,
                format: "dd/mm/yyyy"
            });
        });

        $( ".category-list" ).select2();

        $(document).on('click', '.template-download .btn-danger.delete', function (e) {
            var imgId = $(this).attr('data-imgid');
            removeImage(imgId);
        });

        function removeImage(key) {
            if(key) {
                $.ajax({
                    type: "POST",
                    url: '{{ route('admin.product.deleteReference', ['_token' => csrf_token()]) }}',
                    data: {type: '{{\App\Models\Backend\ShopProduct::TYPE_IMAGE}}', id: key},
                    success: function (data) {
                    }
                });
            }
        }
    </script>
@endpush