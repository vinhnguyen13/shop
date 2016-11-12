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
                        <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Links</a></li>
                        <li class=""><a href="#tab_4" data-toggle="tab" aria-expanded="false">Discount</a></li>
                        <li class=""><a href="#tab_5" data-toggle="tab" aria-expanded="false">Special</a></li>
                        <li class=""><a href="#tab_6" data-toggle="tab" aria-expanded="false">Image</a></li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="tab_1">
                            <div class="form-group">
                                {{ Form::label(null, 'Sku') }}
                                {{ Form::text('sku', $model->sku,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Name') }}
                                {{ Form::text('name', $model->name,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Description') }}
                                {{ Form::textarea('description', $model->description,['id'=>'content', 'class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_2">
                            <div class="form-group">
                                {{ Form::label(null, 'Location') }}
                                {{ Form::text('location', $model->location,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Quantity') }}
                                {{ Form::text('quantity', $model->quantity,['class' => 'form-control'])}}
                            </div>

                            <?php
                            $stock_status = \App\Models\ShopStockStatus::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
                            ?>
                            <div class="form-group">
                                {{ Form::label(null, 'Out Of Stock Status') }}
                                {!! Form::select('stock_status_id', $stock_status, $model->stock_status_id, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Requires Shipping') }} : 
                                {{ Form::radio('shipping', '1', !empty($model->shipping) ? true : false) }} Yes
                                {{ Form::radio('shipping', '0', empty($model->shipping) ? true : false) }} No
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Price') }}
                                {{ Form::text('price', $model->price,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Points') }}
                                {{ Form::text('points', $model->points,['class' => 'form-control'])}}
                            </div>

                            <?php
                            $taxs = \App\Models\ShopTaxClass::query()->orderBy('id')->pluck('title', 'id')->prepend('- Please Select -', 0);
                            ?>
                            <div class="form-group">
                                {{ Form::label(null, 'Tax Class') }}
                                {!! Form::select('tax_class_id', $taxs, $model->tax_class_id, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Date Available') }}
                                {{ Form::text('date_available', $model->date_available,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Weight') }}
                                {{ Form::text('weight', $model->weight,['class' => 'form-control'])}}
                            </div>

                            <?php
                            $weights = \App\Models\ShopWeightClass::query()->orderBy('id')->pluck('title', 'id')->prepend('- Please Select -', 0);
                            ?>
                            <div class="form-group">
                                {{ Form::label(null, 'Weight Class') }}
                                {!! Form::select('weight_class_id', $weights, $model->weight_class_id, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Length') }}
                                {{ Form::text('length', $model->length,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Width') }}
                                {{ Form::text('width', $model->width,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Height') }}
                                {{ Form::text('height', $model->height,['class' => 'form-control'])}}
                            </div>

                            <?php
                            $lengths = \App\Models\ShopLengthClass::query()->orderBy('id')->pluck('title', 'id')->prepend('- Please Select -', 0);
                            ?>
                            <div class="form-group">
                                {{ Form::label(null, 'Length Class') }}
                                {!! Form::select('length_class_id', $lengths, $model->length_class_id, ['class' => 'form-control']) !!}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Subtract') }}
                                {{ Form::text('subtract', $model->subtract,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Minimum') }}
                                {{ Form::text('minimum', $model->minimum,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Order') }}
                                {{ Form::text('order', $model->order,['class' => 'form-control'])}}
                            </div>

                            <div class="form-group">
                                {{ Form::label(null, 'Status') }}
                                {{ Form::select('status', \App\Helpers\AppHelper::statusLabel(), $model->status,['class' => 'form-control'])}}
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_3">
                            <?php
                            $manufacturers = \App\Models\ShopManufacturer::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
                            ?>
                            <div class="form-group">
                                {{ Form::label(null, 'Manufacturer') }}
                                {!! Form::select('manufacturer_id', $manufacturers, $model->manufacturer_id, ['class' => 'form-control']) !!}
                            </div>

                            <?php
                            $categories = \App\Models\ShopCategory::where('status', true)->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
                            ?>
                            <div class="form-group">
                                {{ Form::label(null, 'Category') }}
                                {!! Form::select('category[]', $categories, $categoriesSelected, ['class' => 'form-control category-list', 'multiple'=>'multiple', 'style'=>'width: 100%;']) !!}
                            </div>

                            <?php
                            $suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('company_name', 'id')->prepend('- Please Select -', 0);
                            ?>
                            <div class="form-group">
                                {{ Form::label(null, 'Supplier') }}
                                {!! Form::select('supplier_id', $suppliers, $model->supplier_id, ['class' => 'form-control']) !!}
                            </div>
                        </div>
                        <div class="tab-pane" id="tab_4">
                            @include('product._partials.form-discount')
                        </div>
                        <div class="tab-pane" id="tab_5">
                            @include('product._partials.form-special')
                        </div>
                        <div class="tab-pane" id="tab_6">
                            <div class="form-group">
                                {{ Form::label(null, 'Image') }}
                                {{ Form::file('image', ['url' => route('admin.upload', ['type'=>\App\Services\UploadMedia::UPLOAD_PRODUCT]), 'files' => !empty($image) ? $image : null, 'clientOptions' => ['singleFileUploads' => 1, 'limitMultiFileUploadSize' => 1, 'maxNumberOfFiles' => 1] ]) }}
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

        $('.date').datepicker({
            pickTime: false
        });

        $( ".category-list" ).select2();
    </script>
@endpush