@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Order Product', 'h1_href'=>route('admin.order.index'), 'h1_small'=>'Order Product Management']])
@endsection

@section('grid')
    <div class="grid-action"><a href="{{ route('admin.order.create') }}" class="btn btn-success">Create</a></div>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">Order Product Management</h3>
        </div>
        {!! $grid->table() !!}
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush