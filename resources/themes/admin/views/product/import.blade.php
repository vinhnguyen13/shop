@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product', 'h1_href'=>route('admin.product.index'), 'h1_small'=>'Import']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Import</h3>
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
            {{ Form::open(['route' => 'admin.product.import']) }}
            <div class="form-group">
                <input class="form-control" id="sku" type="text" placeholder="Find product by SKU" name="sku" />
                {{ Form::submit('Save', array('class' => 'btn btn-primary btn-flat')) }}
            </div>
            {{ Form::close() }}
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

@push('styles')
@endpush
@push('scripts')
@endpush