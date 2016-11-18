@extends('layouts.app')

@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'User', 'h1_href'=>route('admin.user.index'), 'h1_small'=>'User Management']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">View Content Detail</h3>
            <a href="{{ route('admin.user.edit', ['id' => $user->id]) }}" class="btn btn-sm btn-info pull-right">Edit</a>
        </div>
        <div class="box-body">
            <div class="form-group">
                {{ Form::label(null, 'Name') }}
                <div>{{ $user->name }}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Email') }}
                <div>{{ $user->email }}</div>
            </div>

        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

