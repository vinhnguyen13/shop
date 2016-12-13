@extends('layouts.app')

@section('content')
<div class="userauth">
    <div class="userauth__inner">
        <h3 class="text-center text-uper fontSFUBold fs-30 mgB-45">create account</h3>
        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
            {{ csrf_field() }}
            <div class="frm-item">
                <input id="name" type="text" placeholder="Name" name="name" value="{{ old('name') }}" required autofocus>
                @if ($errors->has('name'))
                    <span class="help-block">
                        <strong>{{ $errors->first('name') }}</strong>
                    </span>
                @endif
            </div>
            <div class="frm-item">
                <input id="email" type="email" placeholder="Email" name="email" value="{{ old('email') }}" required>
                @if ($errors->has('email'))
                    <span class="help-block">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                @endif
            </div>
            <div class="frm-item">
                <input id="password" type="password" placeholder="Password" name="password" required>
                @if ($errors->has('password'))
                    <span class="help-block">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                @endif
            </div>
            <div class="frm-item">
                <input id="password-confirm" type="password" placeholder="Confirm Password" name="password_confirmation" required>
            </div>
            <div class="frm-item">
                <button type="submit" class="userauth__btn">create</button>
            </div>
        </form>
        <div class="text-center mgT-40">
            <p class="fontSFURe fs-16 text-uper mgB-10 text-decor"><a href="{{ route('login') }}">you have a account ?</a></p>
            <p class="fontSFURe fs-16 text-uper text-decor"><a href="{{ route('password.form') }}">forgot your password ?</a></p>
        </div>
    </div>
</div>
@endsection
