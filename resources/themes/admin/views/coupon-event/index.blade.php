@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Event', 'h1_href'=>route('admin.cpevent.index'), 'h1_small'=>'Coupon Event Management']])
@endsection

@section('grid')
    <div class="grid-action">
        <a href="{{ route('admin.cpevent.create') }}" class="btn btn-success">Create new coupon event</a>
        <a href="{{ route('admin.cpcode.index') }}" class="btn btn-info">Code</a>
    </div>
@endsection

@section('content')
    {!! $grid->table() !!}
@endsection

