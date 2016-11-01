@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'User', 'h1_href'=>route('admin.user.index'), 'h1_small'=>'User Management']])
@endsection

@section('grid')
    <div class="grid-action"><a href="{{ route('admin.user.create') }}" class="btn btn-success">Create</a></div>
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">User Management</h3>
        </div>
        {!! $grid->table() !!}
    </div>
@endsection

@push('styles')
@endpush

@push('scripts')
@endpush