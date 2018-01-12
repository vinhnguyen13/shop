@extends('layouts.print')

@section('content')
    <div class="reciep">
        <div class="reciep__top">
            <p class="reciep__logo"><img src="/themes/v1/icons/logo-footer.svg" alt=""></p>
        </div>
        <div class="reciep__content">
            <p class="font-600 fs-14 mgB-5">DATE/TIME:{{date('Y-m-d H:i:s')}}</p>
            {{--<p class="font-600 fs-14 mgB-5">SERVED BY:</p>--}}
            <p class="font-600 fs-14 mgB-5">INVOICE #: {{$invoice['invoice_number']}}</p>
            <div class="reciep__content--items">
            @if(!empty($invoice['orders']))
                @foreach($invoice['orders'] as $orderProduct)
                    <div class="clearfix">
                        <div class="pull-left">
                            <p class="font-700 fs-14">{{$orderProduct['product_name']}}</p>
                            <div>
                                <span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Size : {{$orderProduct['product_size']}}</span>
                                <span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Qty: {{$orderProduct['product_qty']}}</span>
                            </div>
                        </div>
                        <div class="overflow-all">
                            <p class="font-700 fs-14">{{$orderProduct['product_total']}} đ</p>
                        </div>
                    </div>
                @endforeach
            @endif
            </div>
            <div class="row mgB-20">
                <div class="col-xs-6 text-right">
                    <p class="font-700 fs-14">SUBTOTAL</p>
                    <p class="font-700 fs-14">SHIP AMOUNT</p>
                    <p class="font-700 fs-14">DISCOUNT AMOUNT</p>
                    <p class="font-700 fs-14">TOTAL</p>
                    <p class="font-700 fs-14">PAY BY</p>
                </div>
                <div class="col-xs-6 text-right">
                    <p class="font-700 fs-14">{{number_format($invoice['subtotal'])}} đ</p>
                    <p class="font-700 fs-14">{{number_format($invoice['ship_amount'])}} đ</p>
                    <p class="font-700 fs-14">{{number_format($invoice['discount_amount'])}} đ</p>
                    <p class="font-700 fs-14">{{number_format($invoice['total'])}} đ</p>
                    <p class="font-700 fs-14">Pay At Store</p>
                </div>
            </div>
            <p class="font-600 fs-14 mgB-5">CUSTOMER: {{$invoice['customer']['name']}}</p>
            <p class="font-600 fs-14 mgB-5">EMAIL: {{$invoice['customer']['email']}}</p>
            <p class="font-600 fs-14 mgB-5">PHONE:  {{$invoice['customer']['phone']}}</p>
            <p class="font-600 fs-14 mgB-5">ADDRESS:  {{$invoice['customer']['address']}}</p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-10">QUY ĐỊNH ĐỔI TRẢ HÀNG</p>
            <p class="font-500 fs-13 font-600 text-center mgB-40">Sản phẩm chỉ được đổi trả trong vòng 03 ngày kể từ ngày mua hàng với điều kiện quý khách còn giữ hóa đơn và sản phẩm chưa qua sử dụng còn nguyên nhãn mác từ nhà sản xuất - không áp dụng cho sản phẩm được giảm giá.</p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-10">CTY TNHH THƯƠNG MẠI HÙNG TÂM</p>
            <p class="font-500 fs-13 font-600 text-center mgB-40">135/58 Trần Hưng Đạo , District 1, HCM city , Việt Nam .<br/> glab.vn@gmail.com  -   094 537 88 09  </p>
        </div>
    </div>
    <div id="iframeplaceholder"></div>
@endsection

