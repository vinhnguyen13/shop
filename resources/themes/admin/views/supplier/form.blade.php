@extends('layouts.app')
<?php
$isNewRecord = !empty($model->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Supplier', 'h1_href'=>route('admin.supplier.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> Supplier</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.supplier.store', 'files' => true]) }}
                {{ Form::hidden('id', $model->id) }}
                <div class="form-group">
                    {{ Form::label(null, 'Name') }}
                    {{ Form::text('name', $model->name,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Address') }}
                    {{ Form::text('address', $model->address,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Country') }}
                    {{ Form::text('country_id', $model->country_id,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'City') }}
                    {{ Form::text('city_id', $model->city_id,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'District') }}
                    {{ Form::text('district_id', $model->district_id,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Phone') }}
                    {{ Form::text('phone', $model->phone,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Fax') }}
                    {{ Form::text('fax', $model->fax,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Email') }}
                    {{ Form::text('email', $model->email,['class' => 'form-control'])}}
                </div>


                <div class="form-group">
                    {{ Form::label(null, 'Payment Method') }}
                    {{ Form::text('payment_method', $model->payment_method,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Consignment Fee Type') }}
                    {{ Form::text('consignment_fee_type', $model->consignment_fee_type,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Consignment Fee') }}
                    {{ Form::text('consignment_fee', $model->consignment_fee,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Type Goods') }}
                    {{ Form::text('type_goods', $model->type_goods,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Notes') }}
                    {{ Form::text('notes', $model->notes,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Order') }}
                    {{ Form::text('order', $model->order,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Url') }}
                    {{ Form::text('url', $model->url,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Logo') }}
                    {{ Form::text('logo', $model->logo,['class' => 'form-control'])}}
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
