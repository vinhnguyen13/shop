<div class="checkout__infor__shipping step-checkout">
    <div class="checkout__infor__user__shipping">
        <p class="font-700 mgB-20 fs-24 mgT-20">SHIPPING INFOMATION</p>
        @include('product.checkout.partials.errors')
        <div class="frm-item{{ $errors->has('shipping_name')?" has-error":""}}">
            <input name="shipping_name" placeholder="Họ Tên (*)" class="form-control" type="text" value="{{$checkoutInfo['shipping_name'] or ''}}">
            @if ($errors->has('shipping_name'))
                <div class="error">{{ $errors->first('shipping_name') }}</div>
            @endif
        </div>
        <div class="frm-item{{ $errors->has('shipping_address')?" has-error":""}}">
            <input name="shipping_address" placeholder="Địa chỉ. Vui lòng điền CHÍNH XÁC 'tầng, số nhà, đường'.  (*)" class="form-control" type="text" value="{{$checkoutInfo['shipping_address'] or ''}}">
            @if ($errors->has('shipping_address'))
                <div class="error">{{ $errors->first('shipping_address') }}</div>
            @endif
        </div>
        <div class="frm-item same-city">
            <?php
            $cities = \App\Models\SysCity::query()->orderBy('id')->pluck('name', 'id')->prepend('Tỉnh/Thành phố', 0);
            $districts = ['Quận/Huyện'];
            if($checkoutInfo['shipping_city_id']){
                $districts = \App\Models\SysDistrict::query()->where(['city_id'=>$checkoutInfo['shipping_city_id']])->orderBy('id')->pluck('name', 'id')->prepend('Quận/Huyện', 0);
            }
            $wards = ['Phường/Xã'];
            if($checkoutInfo['shipping_district_id']){
                $wards = \App\Models\SysWard::query()->where(['district_id'=>$checkoutInfo['shipping_district_id']])->orderBy('id')->pluck('name', 'id')->prepend('Phường/Xã', 0);
            }
            ?>
            {!! Form::select('shipping_city_id', $cities, $checkoutInfo['shipping_city_id'], ['class' => 'select-city', 'data-child'=>'district']) !!}
        </div>
        <div class="frm-item same-district">
            {!! Form::select('shipping_district_id', $districts, $checkoutInfo['shipping_district_id'], ['class' => 'select-district', 'data-child'=>'ward']) !!}
        </div>
        <div class="frm-item same-ward">
            {!! Form::select('shipping_ward_id', $wards, $checkoutInfo['shipping_ward_id'], ['class' => 'select-ward']) !!}
        </div>
        <div class="frm-item{{ $errors->has('shipping_phone')?" has-error":""}}">
            <input name="shipping_phone" placeholder="Điện thoại  (*)" class="form-control" type="number" value="{{$checkoutInfo['shipping_phone'] or ''}}">
            @if ($errors->has('shipping_phone'))
                <div class="error">{{ $errors->first('shipping_phone') }}</div>
            @endif
        </div>
        <div class="frm-item">
            <textarea class="form-control" name="comment" placeholder="Lưu ý">{{$checkoutInfo['comment'] or ''}}</textarea>
            <div class="error">abc</div>
        </div>
    </div>
    {{--BILLING--}}
    <div class="checkout__infor__user__billing">
        <p class="font-700 mgB-20 fs-24 mgT-40">BILLING INFORMATION</p>
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
            <input name="billing_name" placeholder="Họ Tên (*)" class="form-control" type="text" value="{{$checkoutInfo['billing_name'] or ''}}">
            @if ($errors->has('billing_name'))
                <div class="error">{{ $errors->first('billing_name') }}</div>
            @endif
        </div>
        <div class="frm-item{{ $errors->has('billing_address')?" has-error":""}}">
            <input name="billing_address" placeholder="Địa chỉ. Vui lòng điền CHÍNH XÁC 'tầng, số nhà, đường'. (*)" class="form-control" type="text" value="{{$checkoutInfo['billing_address'] or ''}}">
            @if ($errors->has('billing_address'))
                <div class="error">{{ $errors->first('billing_address') }}</div>
            @endif
        </div>
        <div class="frm-item same-city">
            <?php
            $cities = \App\Models\SysCity::query()->orderBy('id')->pluck('name', 'id')->prepend('Tỉnh/Thành phố', 0);
            $districts = ['Quận/Huyện'];
            if($checkoutInfo['billing_city_id']){
                $districts = \App\Models\SysDistrict::query()->where(['city_id'=>$checkoutInfo['billing_city_id']])->orderBy('id')->pluck('name', 'id')->prepend('Quận/Huyện', 0);
            }
            $wards = ['Phường/Xã'];
            if($checkoutInfo['billing_district_id']){
                $wards = \App\Models\SysWard::query()->where(['district_id'=>$checkoutInfo['billing_district_id']])->orderBy('id')->pluck('name', 'id')->prepend('Phường/Xã', 0);
            }
            ?>
            {!! Form::select('billing_city_id', $cities, $checkoutInfo['billing_city_id'], ['class' => 'select-city', 'data-child'=>'district']) !!}
        </div>
        <div class="frm-item same-district">
            {!! Form::select('billing_district_id', $districts, $checkoutInfo['billing_district_id'], ['class' => 'select-district', 'data-child'=>'ward']) !!}
        </div>
        <div class="frm-item same-ward">
            {!! Form::select('billing_ward_id', $wards, $checkoutInfo['billing_ward_id'], ['class' => 'select-ward']) !!}
        </div>
        <div class="frm-item{{ $errors->has('billing_phone')?" has-error":""}}">
            <input name="billing_phone" placeholder="Điện thoại (*)" class="form-control" type="number" value="{{$checkoutInfo['billing_phone'] or ''}}">
            @if ($errors->has('billing_phone'))
                <div class="error">{{ $errors->first('billing_phone') }}</div>
            @endif
        </div>
        <div class="frm-item">
            <input name="billing_tax_code" placeholder="Mã số thuế" class="form-control" type="text" value="{{$checkoutInfo['billing_tax_code'] or ''}}">
        </div>
    </div>
    <div class="text-center mgT-30">
        <button class="btn__conti--pay">CONTINUE TO PAYMENT METHOD</button>
    </div>
</div>