@extends('layouts.app')

@section('content')
    <div class="reciep">
        <div class="reciep__top">
            <a href="{{url('/')}}" class="reciep__logo"><img src="/themes/v1/icons/logo-footer.svg" alt=""></a>
            <p class="font-500 fs-13 mgB-5 font-600">135/58 Trần Hưng Đạo , District 1, HCM city , Việt Nam.</p>
            <p class="font-500 fs-13 mgB-15 font-600">glab.vn@gmail.com  -   094 537 88 09</p>
            <p class="font-500 fs-13 font-600">Sản phẩm chỉ được đổi trả trong vòng 03 ngày kể từ ngày mua hàng với điều kiện quý khách còn giữ hóa đơn và sản phẩm chưa qua sử dụng còn nguyên nhãn mác từ nhà sản xuất.</p>
        </div>
        <div class="reciep__content">
            <h2>CUSTOMER RECEIPT</h2>
            <p class="font-600 fs-14 mgB-5">DATE/TIME:{{$order->created_at}}</p>
            {{--<p class="font-600 fs-14 mgB-5">SERVED BY:</p>--}}
            <p class="font-600 fs-14 mgB-5">INVOICE #:{{$order->invoice_code}}</p>
            <?php
                $orderDetails = $order->orderDetails();
                $totalDiscount = $subtotalProduct = 0;
                $totalShipping = $order->total_shipping;
            ?>
            <div class="reciep__content--items">
                @foreach($orderDetails as $orderProduct)
                    <?php
                    $price = $orderProduct->product->getPriceDefault($orderProduct->getSize());
                    $quantity = $orderProduct->quantity;
                    ?>
                    <div class="clearfix">
                        <div class="pull-left">
                            <p class="font-700 fs-14">{{$orderProduct->product->name}}  (SKU : {{$orderProduct->product->sku_producer}})</p>
                            <div>
                                <span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Size : {{$orderProduct->getSize()}}</span>
                                <span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Qty: {{$orderProduct->quantity}}</span>
                            </div>
                        </div>
                        <div class="overflow-all">
                            <p class="font-700 fs-14">{{number_format($price * $quantity)}} đ</p>
                            {{--<p class="font-500 fs-13 color-7c7c7c">-0.00</p>--}}
                        </div>
                    </div>
                    @php
                        $subtotalProduct += $price * $quantity;
                    @endphp
                @endforeach
            </div>
            @php
            $total = $subtotalProduct + $totalShipping - $totalDiscount;
            @endphp
            <div class="row mgB-20">
                <div class="col-xs-6 text-right">
                    <p class="font-700 fs-14">SUBTOTAL</p>
                    <p class="font-700 fs-14">SHIP AMOUNT</p>
                    <p class="font-700 fs-14">DISCOUNT AMOUNT</p>
                    <p class="font-700 fs-14">TOTAL</p>
                    <p class="font-700 fs-14">PAY BY</p>
                </div>
                <div class="col-xs-6 text-right">
                    <p class="font-700 fs-14">{{number_format($subtotalProduct)}} đ</p>
                    <p class="font-700 fs-14">{{number_format($totalShipping)}} đ</p>
                    <p class="font-700 fs-14">{{number_format($totalDiscount)}} đ</p>
                    <p class="font-700 fs-14">{{number_format($total)}} đ</p>
                    <p class="font-700 fs-14">{{$order->paymentMethod->name}}</p>
                </div>
            </div>
            <p class="font-600 fs-14 mgB-5">CUSTOMER: {{$order->customer->name}}</p>
            <p class="font-600 fs-14 mgB-5">EMAIL: {{$order->customer->email}}</p>
            <p class="font-600 fs-14 mgB-5">PHONE:  {{$order->customer->phone}}</p>
            <p class="font-600 fs-14 mgB-5">ADDRESS:  {{$order->customer->locationToText()}}</p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-20">NOTICE!!!</p>
            <p class="font-500 fs-13 font-600 text-center mgB-40">Sản phẩm chỉ được đổi trả trong vòng 03 ngày kể từ ngày mua hàng với điều kiện quý khách còn giữ hóa đơn và sản phẩm chưa qua sử dụng còn nguyên nhãn mác từ nhà sản xuất.</p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-20">THANK YOU AND HOPE YOU HAD GREAT SHOPPING EXPERIENCE</p>
            <div class="text-right mgT-30">
                <button class="btn btn-default btn-sm btn-print"><i class="fa fa-print"></i>Print</button>
            </div>
        </div>
    </div>
    <div id="iframeplaceholder"></div>
@endsection

@push('styles')

@endpush

@push('scripts')
<script type="text/javascript">
    $(function() {
        $('.reciep').on('click', '.btn-print', function (e) {
            var url = '{{route('product.payment.success')}}?order={{$order->id}}&print=1';
            loadiFrame(url);
            $("#printIframe").load(
                    function () {
                        window.frames['myname'].focus();
                        window.frames['myname'].print();
                    }
            );
        });
        function loadiFrame(src) {
            $("#iframeplaceholder").html("<iframe id='printIframe' style='display:none;' name='myname' src='" + src + "' />");
        }
    });
</script>

@endpush