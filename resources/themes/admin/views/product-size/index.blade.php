@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Product Size', 'h1_href'=>route('admin.productSize.index'), 'h1_small'=>'Product Size']])
@endsection

@section('grid')
    <div class="grid-action">
        <a href="{{ route('admin.productSize.create') }}" class="btn btn-success">Create</a>
    </div>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Product Size</h3>
        </div>
        {!! $grid->table() !!}
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush