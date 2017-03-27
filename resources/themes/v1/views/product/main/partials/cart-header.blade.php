
<h2 class="text-uper font-700 fs-16">your cart</h2>
@if(!empty($cart))
    <div class="header__cart--items">
        <?php
        $subtotal = 0;
        $tax = 0;
        $total = 0;
        ?>
        @foreach($cart as $pid => $item)
            <?php
                $size = $item['size'];
                $quantity = $item['quantity'];
                $product = \App\Models\Frontend\ShopProduct::find($pid);
                $price = $product->getPriceDefault($size);
                $subtotalProduct = $price * $quantity;
                $subtotal += $subtotalProduct;
                $tax += $product->taxWithPrice($price);
            ?>
            <a href="" class="header__cart--item clearfix">
                <div class="pull-left wrap-img">
                    <img src="{{$product->thumb()}}" alt="">
                </div>
                <div class="overflow-all">
                    <p class="text-uper fs-15 font-700">{{$product->name}}</p>

                    <p class="product-type text-uper font-500 fs-13 mgB-10">{{$product->color}}</p>

                    <p class="pull-right font-700 fs-12">đ {{number_format($subtotalProduct)}}</p>

                    <p class="text-uper font-700 fs-12">Size: {{$size}} - Quantity: {{$quantity}}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="clearfix mgB-20">
        <span class="text-uper fs-14 font-600">Tạm tính</span>

        <p class="pull-right product-price">đ {{number_format($subtotal)}}</p>
    </div>
    <div class="text-center">
        <p class="font-500 fs-15 mgB-15">Phí vận chuyển và thuế sẽ tính lúc thanh toán</p>
        <a href="{{route('product.checkout', ['step'=>'step1'])}}" class="text-uper btn-checkout ">Thanh toán</a>
    </div>
@else
    <div class="text-center">
        <p class="font-500 fs-15 mgB-15">Không có sản phẩm nào !</p>
    </div>
@endif
