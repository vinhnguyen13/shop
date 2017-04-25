<p class="font-700 mgB-30 text-center fs-24">YOUR CART</p>
<?php
$total = 0;
$subtotal = 0;
$shiptotal = 0;
$coupontotal = 0;
$tax = 0;
$total = 0;
$quantities =[1=>1,2,3,4,5];
$totalItem = 0;
?>
@foreach($cart as $pid=>$item)
<?php
    $size = $item['size'];
    $quantity = $item['quantity'];
    $product = \App\Models\Frontend\ShopProduct::find($pid);
    $price = $product->getPriceDefault($size);
    $subtotalProduct = $price * $quantity;
    $subtotal += $subtotalProduct;
    $tax += $product->taxWithPrice($price);
    $totalItem += $quantity;
?>
<div class="clearfix mgB-40 checkout__inforpro-detail" data-product="{{encrypt($product->id)}}" data-size="{{$size}}">
    <div class="checkout__inforpro--img pull-left">
        <img src="{{$product->thumb()}}" alt="">
    </div>
    <div class="overflow-all">
        <a href="" class="pro-remove removeCart"><span class="icon-uniF335"></span></a>
        <p class="font-600 fs-14"><a href="{{$product->url()}}">{!! $product->name !!}</a></p>
        <p class="font-600 fs-11"><em>SKU:</em> {{$product->sku_producer}}</p>
{{--        <p class="font-600 fs-11"><em>COLOR:</em> {{$product->color}}</p>--}}
        <p class="font-600 fs-11"><em>SIZE:</em> {{$size}}</p>
        <p class="price__item">{{number_format($subtotalProduct)}} đ</p>
        <div class="up__down--qty font-600 fs-11">
            <em>QTY:</em>
            <span class="qty__down"><span class="icon-circle-minus"></span></span>
            <span class="qty__val">{{$quantity}}</span>
            <span class="qty__up"><span class="icon-circle-plus"></span></span>
            <input name="quantity_select" class="quantity_select" type="hidden" value="{{$quantity}}">
        </div>
    </div>
</div>
@endforeach
<?php
$shippingPrice = 0;
if(!empty($checkoutInfo['shipping_city_id'])){
    $shipFee = app(\App\Services\Payment::class)->getShipFeeWithCity($checkoutInfo['shipping_city_id']);
    $shippingPrice = !empty($shipFee->value) ? $shipFee->value : 0;
}
$shiptotal = $shippingPrice * $totalItem;
$total = ($subtotal + $shiptotal) - $coupontotal;
?>
<div class="clearfix mgB-40">
    <p class="pull-right font-600 fs-12">{{number_format($subtotal)}} đ</p>
    <p class="font-600 fs-12">SUBTOTAL</p>
</div>
<div class="clearfix pdL-15 pdR-15 mgB-40 hide">
    <div class="code__promo">
        <input name="coupon_code" type="text" placeholder="PROMO CODE">
    </div>
    <div class="overflow-all">
        <button class="btn-apply-checkout btn-coupon hide">APPLY</button>
    </div>
</div>
<div class="clearfix mgB-10">
    <p class="pull-right font-700 fs-12">{{number_format($shiptotal)}} đ</p>
    <p class="font-700 fs-12">SHIPPING</p>
</div>
<div class="clearfix mgB-40">
    <p class="pull-right font-700 fs-17">{{number_format($total)}} đ</p>
    <p class="font-700 fs-17">TOTAL</p>
</div>
<p class="font-600 text-center mgB-20 fs-11"><a href="" class="color-7c7c7c">REFUND POLICY</a></p>
<p class="font-600 text-center mgB-20 fs-11"><a href="" class="color-7c7c7c">SHIPPING SERVICE INFORMATION</a></p>
<p class="font-600 text-center mgB-20 fs-11"><a href="" class="color-7c7c7c">POLICY &amp; TERM</a></p>
