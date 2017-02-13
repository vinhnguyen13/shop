<div class="form-group">
    {{ Form::label(null, 'Location') }}
    {{ Form::text('location', $model->location,['class' => 'form-control'])}}
</div>

<div class="form-group">
    {{ Form::label(null, 'Stock In') }}
    {{ Form::text('stock_in', $model->stock_in,['class' => 'form-control', 'readonly'=>true])}}
</div>

<div class="form-group">
    {{ Form::label(null, 'Stock Out') }}
    {{ Form::text('stock_out', $model->stock_out,['class' => 'form-control', 'readonly'=>true])}}
</div>

<?php
$stock_status = \App\Models\ShopStockStatus::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
?>
<div class="form-group">
    {{ Form::label(null, 'Out Of Stock Status') }} <span class="fa fa-question-circle" data-toggle="tooltip" title="" data-original-title="Status shown when a product is out of stock"></span>
    {!! Form::select('stock_status_id', $stock_status, $model->stock_status_id, ['class' => 'form-control']) !!}
</div>

<div class="form-group">
    {{ Form::label(null, 'Requires Shipping') }} :
    {{ Form::radio('shipping', '1', !empty($model->shipping) ? true : false) }} Yes
    {{ Form::radio('shipping', '0', empty($model->shipping) ? true : false) }} No
</div>

<div class="form-group">
    {{ Form::label(null, 'Color') }}
    {{ Form::text('color', $model->color,['class' => 'form-control'])}}
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
    {{ Form::text('date_available', Carbon\Carbon::parse($model->date_available)->format('d/m/Y'),['class' => 'form-control date'])}}
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
    {{ Form::label(null, 'Order') }}
    {{ Form::text('order', $model->order,['class' => 'form-control'])}}
</div>

<div class="form-group">
    {{ Form::label(null, 'Status') }}
    {{ Form::select('status', \App\Helpers\AppHelper::statusLabel(), $model->status,['class' => 'form-control'])}}
</div>