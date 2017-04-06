<div class="checkout__infor__user step-checkout">
    {{--USER--}}
    <p class="font-700 mgB-20 fs-24 mgT-20">PLEASE ENTER YOUR EMAIL</p>
    @include('product.checkout.partials.errors')
    <div id="email__pay">
        {{ csrf_field() }}
        <div class="frm-item{{ $errors->has('email')?" has-error":""}}">
            <input name="email" type="text" placeholder="EMAIL" value="{{$checkoutInfo['email'] or ''}}">
            @if ($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="mgT-30 mgB-50">
            <label for="user-exist1" class="frm">
                <input id="user-exist1" type="radio" name="user-exist" value="0" checked>Order without registration
            </label>
            <label for="user-exist2" class="frm">
                <input id="user-exist2" type="radio" name="user-exist" value="1">I already have an account at G-LAB
            </label>
        </div>
        <div class="frm-item">
            <input name="password" type="password" placeholder="PASSWORD" disabled>
        </div>
        <button class="btn__email">CONTINUE</button>
    </div>
</div>