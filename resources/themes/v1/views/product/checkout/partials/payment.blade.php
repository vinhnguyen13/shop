<div class="checkout__infor__payment step-checkout">
    <p class="fontSFUBold mgT-30 fs-24 text-center mgB-50">PAYMENT MENTHOD</p>
    @if($is_seller)
    <div class="mgB-10">
        <label for="" class="frm">
            <input name="payment_method" type="radio" value="PayAtStore" checked>PAY AT STORE
        </label>
    </div>
    @endif
    <div class="mgB-10">
        <label for="" class="frm">
            <input name="payment_method" type="radio" value="OrderOnline">ORDER ONLINE
        </label>
    </div>
    <div class="mgB-10 hide">
        <div class="pull-right">
            <span class="icon-v-i-s-a mgR-10 fs-20"></span>
            <span class="icon-m-a-s-t-e-r mgR-10 fs-20"></span>
            <span class="icon-a-m-e-x fs-20"></span>
        </div>
        <label for="" class="frm">
            <input name="payment_method" type="radio" value="VISA">VISA/ MASTERCARD
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
        <label for="" class="frm">
            <input name="payment_method" type="radio" value="IB_ONLINE">INTERNET BANKING
        </label>
    </div>
    <button class="btn-submit-checkout btn-checkout btn-order">Next</button>
</div>