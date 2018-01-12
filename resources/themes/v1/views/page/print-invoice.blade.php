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
        	<form action="" id="invoicePrint" method="POST">
            <h2>CUSTOMER RECEIPT</h2>
            <p class="font-600 fs-14 mgB-5">DATE/TIME:{{date('Y-m-d H:i:s')}}</p>
            {{--<p class="font-600 fs-14 mgB-5">SERVED BY:</p>--}}
            <p class="font-600 fs-14 mgB-5">INVOICE #:<input type="text" class="input-label" name="invoice[invoice_number]" placeholder="INVOICE NUMBER"></p>
            <div class="reciep__content--items">
                    <div class="clearfix product-item">
                        <div class="pull-left">
                            <p class="font-700 fs-14"><input type="text" class="input-label" name="invoice[orders][1][product_name]" placeholder="Product Name - SKU"></p>
                            <div>
                                <span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Size : <input type="text" class="input-label" name="invoice[orders][1][product_size]" placeholder="Product Size"></span>
                                <span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Qty: <input type="text" class="input-label" name="invoice[orders][1][product_qty]" placeholder="Quanlity"></span>
                            </div>
                        </div>
                        <div class="overflow-all">
                            <p class="font-700 fs-14"><input type="text" class="input-label" name="invoice[orders][1][product_price]" placeholder="Product Price"> đ</p>
                            <input type="hidden" class="input-label" name="invoice[orders][1][product_total]">
                        </div>
                    </div>
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
                    <p class="font-700 fs-14">000 đ</p>
                    <p class="font-700 fs-14"><input type="number" class="input-label text-right" name="invoice[ship_amount]" value="0"> đ</p>
                    <p class="font-700 fs-14"><input type="number" class="input-label text-right" name="invoice[discount_amount]" value="0"> đ</p>
                    <p class="font-700 fs-14">000 đ</p>
                    <p class="font-700 fs-14">Pay At Store</p>
                    <input type="hidden" name="invoice[subtotal]" value="0">
                    <input type="hidden" name="invoice[total]" value="0">
                </div>
            </div>
            <p class="font-600 fs-14 mgB-5">CUSTOMER: <input type="text" class="input-label" name="invoice[customer][name]" placeholder="CUSTOMER"></p>
            <p class="font-600 fs-14 mgB-5">EMAIL: <input type="text" class="input-label" name="invoice[customer][email]" placeholder="EMAIL"></p>
            <p class="font-600 fs-14 mgB-5">PHONE:  <input type="text" class="input-label" name="invoice[customer][phone]" placeholder="PHONE"></p>
            <p class="font-600 fs-14 mgB-5">ADDRESS:  <input type="text" class="input-label" name="invoice[customer][address]" placeholder="ADDRESS"></p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-20">NOTICE!!!</p>
            <p class="font-500 fs-13 font-600 text-center mgB-40">Sản phẩm chỉ được đổi trả trong vòng 03 ngày kể từ ngày mua hàng với điều kiện quý khách còn giữ hóa đơn và sản phẩm chưa qua sử dụng còn nguyên nhãn mác từ nhà sản xuất.</p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-20">THANK YOU AND HOPE YOU HAD GREAT SHOPPING EXPERIENCE</p>
            <div class="text-right mgT-30">
                <button class="btn btn-default btn-sm btn-print"><i class="fa fa-print"></i>Print</button>
            </div>
            <input type="hidden" name="print" value="1">
            {{ csrf_field() }}
            </form>
        </div>
    </div>
    <div id="iframeplaceholder"></div>
@endsection

@push('styles')
<link href="{!! asset('css/front/custom.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
<script type="text/javascript">
    $(function() {
        var url = '{{route('page.print-invoice')}}?print=1';
        loadiFrame(url);
        $('.reciep').on('click', '.btn-print', function (e) {
            $('#invoicePrint').attr('target', 'framePrint');
            $('#invoicePrint').submit();
            $("#printIframe").load(
                    function () {
                        window.frames['framePrint'].focus();
                        window.frames['framePrint'].print();
                    }
            );
            return false;
        });
        function loadiFrame(src) {
            $("#iframeplaceholder").html("<iframe id='printIframe' style='display:none;' name='framePrint' src='" + src + "' />");
        }
    });
</script>

@endpush