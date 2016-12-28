@extends('layouts.app')
<?php
$isNewRecord = !empty($model->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Customer', 'h1_href'=>route('admin.customer.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> Customer</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.customer.store', 'files' => true]) }}
                {{ Form::hidden('id', $model->id) }}
                <div class="form-group">
                    {{ Form::label(null, 'Customer Group') }}
                    {{ Form::text('customer_group_id', $model->customer_group_id,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Name') }}
                    {{ Form::text('name', $model->name,['class' => 'form-control'])}}
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
                    {{ Form::label(null, 'Card') }}
                    {{ Form::text('card', $model->card,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Company') }}
                    {{ Form::text('company', $model->company,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Address 1') }}
                    {{ Form::text('address_1', $model->address_1,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Address 2') }}
                    {{ Form::text('address_2', $model->address_2,['class' => 'form-control'])}}
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
                    {{ Form::submit('Save', array('class' => 'btn btn-primary btn-flat')) }}
                </div>
            {{ Form::close() }}
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection
