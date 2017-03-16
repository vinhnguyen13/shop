<div class="checkout__infor__user step-checkout hide">
    {{--USER--}}
    <div class="checkout__checkuser">
        <div class="frm-item has-error">
            <input name="email" required type="text" placeholder="EMAIL">
            @if ($errors->has('email'))
                <div class="error">{{ $errors->first('email') }}</div>
            @endif
        </div>
        <div class="row mgB-20">
            <div class="col-sm-12">
                <label for="user-exist1" class="frm">
                    <input id="user-exist1" type="radio" name="user-exist" value="0" checked>Order without registration
                </label>
            </div>
            <div class="col-sm-12">
                <label for="user-exist2" class="frm">
                    <input id="user-exist2" type="radio" name="user-exist" value="1">I already have an account at G-LAB
                </label>
            </div>
        </div>
        <div class="frm-item">
            <input name="password" type="password" placeholder="PASSWORD" disabled>
        </div>
        <button class="btn-checkout btn-authentication">Next</button>
    </div>

</div>