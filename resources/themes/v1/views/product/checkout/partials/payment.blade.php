<div class="checkout__infor__payment step-checkout">
    <p class="font-700 fs-24 mgB-50">PAYMENT MENTHOD</p>
    @include('product.checkout.partials.errors')
    @if ($errors->has('payment_method'))
        <div class="frm-item has-error">
            <div class="error">{{ $errors->first('payment_method') }}</div>
        </div>
    @endif
    @if($is_seller)
    <div class="mgB-10">
        <label for="opt-1" class="frm">
            <input id="opt-1" name="payment_method" type="radio" value="PayAtStoreCash" checked>PAY AT STORE: CASH
        </label>
    </div>
    <div class="mgB-10">
        <label for="opt-2" class="frm">
            <input id="opt-2" name="payment_method" type="radio" value="PayAtStoreTransfer">PAY AT STORE: TRANSFER
        </label>
    </div>
    @endif
    <div class="mgB-10">
        <label for="opt-3" class="frm">
            <input id="opt-3" name="payment_method" type="radio" value="OrderOnline"@if(!$is_seller) checked @endif>ORDER ONLINE
        </label>
    </div>
    <div class="mgB-10 hide">
        <div class="pull-right">
            <span class="icon-v-i-s-a mgR-10 fs-20"></span>
            <span class="icon-m-a-s-t-e-r mgR-10 fs-20"></span>
            <span class="icon-a-m-e-x fs-20"></span>
        </div>
        <label for="opt-4" class="frm">
            <input id="opt-4" name="payment_method" type="radio" value="VISA">VISA/ MASTERCARD
        </label>
    </div>
    <div class="pay__method pay__credit hide">
        <div class="frm-item has-error">
            <div class="frm-item-icon">
                <input type="text" placeholder="CARD NUMBER" />
                <span class="icon-l-o-c-k"></span>
            </div>
            <div class="error">abc</div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="frm-item">
                    <input type="text" placeholder="NAME ON CARD" />
                    <div class="error"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="frm-item">
                    <input type="text" placeholder="MM/YY" />
                    <div class="error"></div>
                </div>
            </div>
            <div class="col-lg-3">
                <div class="frm-item has-error">
                    <div class="frm-item-icon">
                        <input type="text" placeholder="CVV" />
                        <span class="icon-question-mark"></span>
                    </div>
                    <div class="error">abc</div>
                </div>
            </div>
        </div>
    </div>
    <div class="mgB-10 hide">
        <label for="opt-5" class="frm">
            <input id="opt-5" name="payment_method" type="radio" value="IB_ONLINE">INTERNET BANKING
        </label>
    </div>
    <div class="text-center mgT-40">
        <button class="btn__comp--order">COMPLETE ORDER</button>
        <p class="font-600 fs-14 mgB-50">By Clicking "Complete Order" you are accepting <br> G-LAB Terms and Conditions.</p>
        <a href="{{route('product.checkout', ['step'=>'step2'])}}" class="font-600 d-ib fs-12 text-uper "><span class="icon-b-a-c-k d-ib mgR-15 fs-13"></span>Return to filling infomation</a>
    </div>
</div>