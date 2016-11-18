@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Supplier', 'h1_href'=>route('admin.supplier.index'), 'h1_small'=>'Supplier Management']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Detail</h3>
            <a href="{{ route('admin.supplier.edit', ['id' => $model->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label('company_name', 'Company Name') }}
                <div>{{ $model->company_name }}</div>
            </div>

            <div class="form-group">
                {{ Form::label('contact_name', 'Contact Name') }}
                <div>{{ $model->contact_name }}</div>
            </div>
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

