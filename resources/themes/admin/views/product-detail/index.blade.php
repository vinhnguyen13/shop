@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product', 'h1_href'=>route('admin.product-detail.index'), 'h1_small'=>'Product Detail Management']])
@endsection

@section('grid')
    <div class="grid-action">
    </div>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Product Management</h3>
        </div>
        {!! $grid->table() !!}
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush