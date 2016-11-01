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
                {{ Form::label(null, 'Username') }}
                <div>{{ $user->username }}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Email') }}
                <div>{{ $user->email }}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Confirmed time') }}
                <div>{!! date('M d, Y H:i', $user->confirmed_at) !!}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Registration Time') }}
                <div>{!! date('M d, Y H:i', $user->created_at) !!}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Registration Ip') }}
                <div>{!! $user->registration_ip !!}</div>
            </div>

            <div class="form-group">
                {{ Form::label(null, 'Last Activity') }}
                <div>{!! date('M d, Y H:i', $user->updated_at) !!}</div>
            </div>

            @include('user.view-profile', compact('profile'))

        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection

