@extends('layouts.app')

@section('content')
    <div class="reciep">
        <div class="reciep__top">
            <p class="reciep__logo"><img src="/themes/v1/icons/logo-footer.svg" alt=""></p>
        </div>
        <div class="reciep__content">
        	<form action="" id="invoicePrint" method="POST">
            <p class="font-600 fs-14 mgB-5">DATE/TIME:{{date('Y-m-d H:i:s')}}</p>
            {{--<p class="font-600 fs-14 mgB-5">SERVED BY:</p>--}}
            <p class="font-600 fs-14 mgB-5">INVOICE #:<input type="text" class="input-label" name="invoice[invoice_number]" placeholder="INVOICE NUMBER"></p>
            <div class="reciep__content--items">
            	<div class="product-items">
                    <!-- product invoice in here -->
                </div>
                <div class="row">
                	<button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-add-more" data-original-title="Add Detail"><i class="fa fa-plus-circle"></i></button>
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
                <div class="col-xs-6 text-right reciep__content--amount">
                    <p class="font-700 fs-14 subtotal">000 đ</p>
                    <p class="font-700 fs-14 ship_amount"><input type="number" class="input-label text-right shipAmountValue" name="invoice[ship_amount]" value="0"> đ</p>
                    <p class="font-700 fs-14 discount_amount"><input type="number" class="input-label text-right discountAmountValue" name="invoice[discount_amount]" value="0"> đ</p>
                    <p class="font-700 fs-14 total">000 đ</p>
                    <p class="font-700 fs-14">Pay At Store</p>
                    <input type="hidden" class="subtotalValue" name="invoice[subtotal]" value="0">
                    <input type="hidden" class="totalValue" name="invoice[total]" value="0">
                </div>
            </div>
            <p class="font-600 fs-14 mgB-5">CUSTOMER: <input type="text" class="input-label" name="invoice[customer][name]" placeholder="CUSTOMER"></p>
            <p class="font-600 fs-14 mgB-5">EMAIL: <input type="text" class="input-label" name="invoice[customer][email]" placeholder="EMAIL"></p>
            <p class="font-600 fs-14 mgB-5">PHONE:  <input type="text" class="input-label" name="invoice[customer][phone]" placeholder="PHONE"></p>
            <p class="font-600 fs-14 mgB-5">ADDRESS:  <input type="text" class="input-label" name="invoice[customer][address]" placeholder="ADDRESS"></p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-10">QUY ĐỊNH ĐỔI TRẢ HÀNG</p>
            <p class="font-500 fs-13 font-600 text-center mgB-40">Sản phẩm chỉ được đổi trả trong vòng 03 ngày kể từ ngày mua hàng với điều kiện quý khách còn giữ hóa đơn và sản phẩm chưa qua sử dụng còn nguyên nhãn mác từ nhà sản xuất - không áp dụng cho sản phẩm được giảm giá.</p>
            <p class="font-700 fs-14 text-center mgT-20 mgB-10">CTY TNHH THƯƠNG MẠI HÙNG TÂM</p>
            <p class="font-500 fs-13 font-600 text-center mgB-40">135/58 Trần Hưng Đạo , District 1, HCM city , Việt Nam .<br/> glab.vn@gmail.com  -   094 537 88 09  </p>
            <div class="text-right mgT-30">
                <button class="btn btn-glab btn-default btn-sm btn-print"><i class="fa fa-print"></i>Print</button>
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
        var index = 1;
        var htmlProductInvoice = addProductInvoice(index);
		$('.product-items').html(htmlProductInvoice);
        
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

        $('.reciep').on('click', '.btn-add-more', function (e) {
        	index++;
        	var htmlProductInvoice = addProductInvoice(index);
    		$('.product-items').append(htmlProductInvoice);
        	return false;
        });
        
        $('.reciep .product-items').on('blur', '.product-item-total', function (e) {
			updateAmount();
        	return true;
        });  

        $('.reciep').on('blur', '.shipAmountValue', function (e) {
			updateAmount();
        	return true;
        });  

        $('.reciep').on('blur', '.discountAmountValue', function (e) {
			updateAmount();
        	return true;
        });  

        loadiFrame();
        function loadiFrame() {
            var url = '{{route('page.print-invoice')}}?print=1';
            $("#iframeplaceholder").html("<iframe id='printIframe' style='display:none;' name='framePrint' src='" + url + "' />");
        }

        function addProductInvoice(idx) {
            var html = '<div class="clearfix product-item">';
                	html += '<div class="pull-left">';
                		html += '<p class="font-700 fs-14"><input type="text" class="input-label" name="invoice[orders]['+idx+'][product_name]" placeholder="Product Name - SKU"></p>';
                		html += '<div>';
                			html += '<span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Size : <input type="text" class="input-label" name="invoice[orders]['+idx+'][product_size]" placeholder="Product Size"></span>';
            				html += '<span class="font-500 fs-13 d-ib mgR-15 color-7c7c7c">Qty: <input type="text" class="input-label" name="invoice[orders]['+idx+'][product_qty]" placeholder="Quanlity"></span>';
    					html += '</div>';
    				html += '</div>';
					html += '<div class="overflow-all">';
						html += '<p class="font-700 fs-14"><input type="text" class="input-label product-item-total" name="invoice[orders]['+idx+'][product_total]" placeholder="Product Price Total"> đ</p>';
					html += '</div>';
				html += '</div>';
			return html;
        }

        function updateAmount() {
        	var _productSubTotal = 0, _productItemTotal = 0, _productTotal = 0;
        	var _wrapAmount = $('.reciep__content--amount');
        	$('.reciep .product-items .product-item').each(function() {
        		_productAmount = parseInt($(this).find('.product-item-total').val());		
        		console.log(_productAmount);	
        		_productSubTotal += _productAmount;   
        	});
        	_wrapAmount.find('.subtotal').html(_productSubTotal+' đ');
            _wrapAmount.find('.subtotalValue').val(_productSubTotal);
            var _shipAmountValue = parseInt(_wrapAmount.find('.shipAmountValue').val());
            var _discountAmountValue = parseInt(_wrapAmount.find('.discountAmountValue').val());
            _productTotal = _productSubTotal + _shipAmountValue - _discountAmountValue;
            _wrapAmount.find('.total').html(_productTotal+' đ');
            _wrapAmount.find('.totalValue').val(_productTotal);
        }
    });
</script>

@endpush