<div class="step-checkout" id="wrap-payment">
    <div class="text-center mgB-20">
        <h2>Chọn phương thức thanh toán</h2>
    </div>
    <div class="checkout__slect--payment">
        <ul>
            <li>
                <label for="CashOnDelivery">
                    <span>Thanh toán <br> khi nhận hàng</span>
                    <input type="radio" name="option_payment" value="CashOnDelivery" id="CashOnDelivery" checked>
                </label>
            </li>
            <li>
                <label for="ATM_ONLINE">
                    <span>Thẻ ATM <br> nội địa</span>
                    <input type="radio" name="option_payment" value="ATM_ONLINE" id="ATM_ONLINE">
                </label>
            </li>
            <li>
                <label for="IB_ONLINE">
                    <span>INTERNET BANKING</span>
                    <input type="radio" name="option_payment" value="IB_ONLINE" id="IB_ONLINE">
                </label>
            </li>
            <li>
                <label for="ATM_OFFLINE">
                    <span>Thẻ ATM <br> OFFLINE</span>
                    <input type="radio" name="option_payment" value="ATM_OFFLINE" id="ATM_OFFLINE">
                </label>
            </li>
            <li>
                <label for="VISA">
                    <span>VISA /<br> MASTERCARD</span>
                    <input type="radio" name="option_payment" value="VISA" id="VISA">
                </label>
            </li>
        </ul>
    </div>
    <p class="font-bold fs-14 mgB-10">Để thực hiện việc thanh toán, bắt buộc thẻ ATM của bạn đã có đăng ký sử dụng dịch vụ Internet Banking.</p>
    <p class="mgB-10">Chọn ngân hàng của bạn</p>
    @php
    $optionDefault = [''=>'Vui lòng chọn ngân hàng'];
    @endphp
    {!! Form::select('payment_bank', array_collapse([trans('payment.ATM_ONLINE'), $optionDefault]), null, ['class' => 'checkout__bank']) !!}
    {!! Form::select('payment_bank', array_collapse([trans('payment.IB_ONLINE'), $optionDefault]), null, ['class' => 'checkout__bank']) !!}
    {!! Form::select('payment_bank', array_collapse([trans('payment.ATM_OFFLINE'), $optionDefault]), null, ['class' => 'checkout__bank']) !!}
    {!! Form::select('payment_bank', array_collapse([trans('payment.NH_OFFLINE'), $optionDefault]), null, ['class' => 'checkout__bank']) !!}
    {!! Form::select('payment_bank', array_collapse([trans('payment.VISA'), $optionDefault]), null, ['class' => 'checkout__bank']) !!}

</div>
