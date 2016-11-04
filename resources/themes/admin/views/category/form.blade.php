@extends('layouts.app')
<?php
$isNewRecord = !empty($user->id) ? false : true;
?>
@section('content-header')
    @include('layouts._partials.content-header', ['data'=>['h1'=>'User', 'h1_href'=>route('admin.user.index'), 'h1_small'=>$isNewRecord ? 'Create' : 'Edit']])
@endsection

@section('content')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title"><?php echo $isNewRecord ? "Create" : "Edit"?> User</h3>
        </div>
        <div class="box-body">
            {{ Form::open(['route' => 'admin.user.store', 'files' => true]) }}
                <div class="form-group">
                    {{ Form::label(null, 'Username') }}
                    {{ Form::text('username', $user->username,['class' => 'form-control'])}}
                    {{ Form::hidden('id', $user->id) }}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Email') }}
                    {{ Form::text('email', $user->email,['class' => 'form-control'])}}
                </div>

                <div class="form-group">
                    {{ Form::label(null, 'Password') }}
                    {{ Form::text('password', null,['class' => 'form-control'])}}
                </div>

                @include('user.form-profile', compact('profile'))

                <div class="form-group">
                    {{ Form::submit('Save', array('class' => 'btn btn-primary btn-flat')) }}
                </div>
            {{ Form::close() }}
        </div>
        <div class="box-footer clearfix">

        </div>
    </div>
@endsection
