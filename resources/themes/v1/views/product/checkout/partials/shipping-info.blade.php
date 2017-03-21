<div class="checkout__infor__shipping step-checkout">
    {{--SHIPPING--}}
    <div class="checkout__infor__user__shipping">
        <p class="fontSFUBold mgB-20 fs-24 mgT-20">SHIPPING INFOMATION</p>
        <div class="frm-item{{ $errors->has('shipping_name')?" has-error":""}}">
            <input name="shipping_name" placeholder="Họ Tên (*)" class="form-control" type="text">
            @if ($errors->has('shipping_name'))
                <div class="error">{{ $errors->first('shipping_name') }}</div>
            @endif
        </div>
        <div class="frm-item{{ $errors->has('shipping_address')?" has-error":""}}">
            <input name="shipping_address" placeholder="Địa chỉ. Vui lòng điền CHÍNH XÁC 'tầng, số nhà, đường'.  (*)" class="form-control" type="text">
            @if ($errors->has('shipping_address'))
                <div class="error">{{ $errors->first('shipping_address') }}</div>
            @endif
        </div>
        <div class="frm-item same-city">
            <?php
            $cities = \App\Models\SysCity::query()->orderBy('id')->pluck('name', 'id')->prepend('Tỉnh/Thành phố', 0);
            ?>
            {!! Form::select('shipping_city_id', $cities, null, ['class' => 'select-city', 'data-child'=>'district']) !!}
        </div>
        <div class="frm-item same-district">
            {!! Form::select('shipping_district_id', ['Quận/Huyện'], null, ['class' => 'select-district', 'data-child'=>'ward']) !!}
        </div>
        <div class="frm-item same-ward">
            {!! Form::select('shipping_ward_id', ['Phường/Xã'], null, ['class' => 'select-ward']) !!}
        </div>
        <div class="frm-item{{ $errors->has('shipping_phone')?" has-error":""}}">
            <input name="shipping_phone" placeholder="Điện thoại  (*)" class="form-control" type="text">
            @if ($errors->has('shipping_phone'))
                <div class="error">{{ $errors->first('shipping_phone') }}</div>
            @endif
        </div>
        <div class="frm-item">
            <textarea class="form-control" name="comment" placeholder="Lưu ý"></textarea>
            <div class="error">abc</div>
        </div>
    </div>
    {{--BILLING--}}
    <div class="checkout__infor__user__billing">
        <p class="fontSFUBold mgB-20 fs-24 mgT-40">BILLING INFORMATION</p>
        <div class="row mgB-20">
            <div class="col-sm-6">
                <label for="" class="frm">
                    <input type="radio" name="chk-same-info" checked value="1">SAME AS SHIPPING
                </label>
            </div>
            <div class="col-sm-6">
                <label for="" class="frm">
                    <input type="radio" name="chk-same-info" value="0">ENTER DIFFERENT BILLING ADDRESS
                </label>
            </div>
        </div>
        <div class="frm-item{{ $errors->has('billing_name')?" has-error":""}}">
            <input name="billing_name" placeholder="Họ Tên (*)" class="form-control" type="text">
            @if ($errors->has('billing_name'))
                <div class="error">{{ $errors->first('billing_name') }}</div>
            @endif
        </div>
        <div class="frm-item{{ $errors->has('billing_address')?" has-error":""}}">
            <input name="billing_address" placeholder="Địa chỉ. Vui lòng điền CHÍNH XÁC 'tầng, số nhà, đường'. (*)" class="form-control" type="text">
            @if ($errors->has('billing_address'))
                <div class="error">{{ $errors->first('billing_address') }}</div>
            @endif
        </div>
        <div class="frm-item same-city">
            <?php
            $cities = \App\Models\SysCity::query()->orderBy('id')->pluck('name', 'id')->prepend('Tỉnh/Thành phố', 0);
            ?>
            {!! Form::select('billing_city_id', $cities, null, ['class' => 'select-city', 'data-child'=>'district']) !!}
        </div>
        <div class="frm-item same-district">
            {!! Form::select('billing_district_id', ['Quận/Huyện'], null, ['class' => 'select-district', 'data-child'=>'ward']) !!}
        </div>
        <div class="frm-item same-ward">
            {!! Form::select('billing_ward_id', ['Phường/Xã'], null, ['class' => 'select-ward']) !!}
        </div>
        <div class="frm-item{{ $errors->has('billing_phone')?" has-error":""}}">
            <input name="billing_phone" placeholder="Điện thoại (*)" class="form-control" type="text">
            @if ($errors->has('billing_phone'))
                <div class="error">{{ $errors->first('billing_phone') }}</div>
            @endif
        </div>
        <div class="frm-item">
            <input name="billing_tax_code" placeholder="Mã số thuế" class="form-control" type="text">
        </div>
    </div>
    <div class="text-center mgT-40">
        <button class="btn__comp--order">Continue</button>
    </div>
</div>