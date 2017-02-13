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
    {!! Form::select('category[]', $categories, !empty($categoriesSelected) ? $categoriesSelected : [], ['class' => 'form-control category-list', 'multiple'=>'multiple', 'style'=>'width: 100%;']) !!}
</div>