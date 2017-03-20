<p class="fontSFUBold mgB-30 text-center fs-24">YOUR CART</p>
<?php
$total = 0;
$subtotal = 0;
$shiptotal = 0;
$coupontotal = 0;
$tax = 0;
$total = 0;
$quantities =[1=>1,2,3,4,5];
?>
@foreach($cart as $item)
<?php
    $productDetail = App\Models\Frontend\ShopProductDetail::find($item['detailID']);
    $product = $productDetail->product;
    $price = $productDetail->getPrice();
    $subtotalProduct = $price * $item['quantity'];
    $subtotal += $subtotalProduct;
    $tax += $product->taxWithPrice($price);
?>
<div class="clearfix mgB-40 checkout__inforpro-detail" data-product-detail="{{encrypt($item['detailID'])}}">
    <div class="checkout__inforpro--img pull-left">
        <img src="{{$product->thumb()}}" alt="">
    </div>
    <div class="overflow-all">
        <a href="" class="pro-remove removeCart"><span class="icon-uniF335"></span></a>
        <p class="fontSFUMeBold fs-20">{!! $product->name !!}</p>
        <p class="fontSFUMeBold fs-12"><em>SKU:</em> {{$productDetail->sku}}</p>
        <p class="fontSFUMeBold fs-12"><em>COLOR:</em> {{$product->color}}</p>
        <p class="fontSFUMeBold fs-12"><em>SIZE:</em> {{$productDetail->size}}</p>
        <p class="price__item">{{number_format($subtotalProduct)}} đ</p>
        <p class="fontSFUMeBold fs-12">QTY: {!! Form::select('quantity_select', $quantities, $item['quantity'], ['class' => 'quantity_select']) !!}</p>
    </div>
</div>
@endforeach
<?php
$total = ($subtotal + $shiptotal) - $coupontotal;
?>
<div class="clearfix mgB-40">
    <p class="pull-right fontSFUMeBold fs-18 font-bold">{{number_format($subtotal)}} đ</p>
    <p class="fontSFUMeBold fs-18 font-bold">SUBTOTAL</p>
</div>
<div class="clearfix pdL-15 pdR-15 mgB-40">
    <div class="code__promo">
        <input name="coupon_code" type="text" placeholder="PROMO CODE">
    </div>
    <div class="overflow-all">
        <button class="btn-apply-checkout btn-coupon hide">APPLY</button>
    </div>
</div>
<div class="clearfix mgB-10">
    <p class="pull-right fontSFUMeBold fs-18 font-bold">{{number_format($shiptotal)}} đ</p>
    <p class="fontSFUMeBold fs-18 font-bold">SHIPPING</p>
</div>
<p class="fontSFUMeBold fs-18 color-7c7c7c mgB-40">Shipping fee will be caculated from your address</p>
<div class="clearfix mgB-40">
    <p class="pull-right fontSFUBold fs-24">{{number_format($total)}} đ</p>
    <p class="fontSFUBold fs-24">TOTAL</p>
</div>
<p class="color-7c7c7c fontSFUMeBold text-center mgB-20 fs-18"><a href="">REFUND POLICY</a></p>
<p class="color-7c7c7c fontSFUMeBold text-center mgB-20 fs-18"><a href="">SHIPPING SERVICE INFORMATION</a></p>
<p class="color-7c7c7c fontSFUMeBold text-center mgB-20 fs-18"><a href="">POLICY &amp; TERM</a></p>
