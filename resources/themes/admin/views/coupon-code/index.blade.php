@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'Coupon Code', 'h1_href'=>route('admin.cpcode.index'), 'h1_small'=>'Coupon Code Management']])
@endsection

@section('grid')
    <div class="grid-action">
        <a href="{{ route('admin.cpcode.create') }}" class="btn btn-success">Create</a>
        <a href="{{ route('admin.cpcode.create-random') }}" class="btn btn-success">Create random code</a>
        <a href="{{ route('admin.cpevent.index') }}" class="btn btn-info">Event</a>
    </div>
@endsection

@section('content')
    {!! $grid->table() !!}
@endsection

