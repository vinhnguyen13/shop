<div class="form-group required">
    {{ Form::label(null, 'Sku') }}
    {{ Form::text('sku', $model->sku,['class' => 'form-control'])}}
</div>

<div class="form-group required">
    {{ Form::label(null, 'Name') }}
    {{ Form::text('name', $model->name,['class' => 'form-control'])}}
</div>

<div class="form-group required">
    {{ Form::label(null, 'Description') }}
    {{ Form::textarea('description', $model->description,['id'=>'content', 'class' => 'form-control'])}}
</div>