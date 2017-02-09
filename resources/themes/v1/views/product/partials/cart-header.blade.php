
<h2 class="text-uper fontSFUBold fs-16">your cart</h2>
@if(!empty($cart))
    <div class="header__cart--items">
        <?php
        $subtotal = 0;
        $tax = 0;
        $total = 0;
        ?>
        @foreach($cart as $item)
            <?php
            $product = App\Models\Frontend\ShopProduct::find($item['product_id']);
            $product->setCart($item['sizeID'], $item['quantity']);
            $price = $product->priceWithSize();
            $subtotalProduct = $price * $item['quantity'];
            $subtotal += $subtotalProduct;
            $tax += $product->taxWithPrice($price);
            ?>
            <a href="" class="header__cart--item clearfix">
                <div class="pull-left wrap-img">
                    <img src="/themes/v1/images/310x177.jpg" alt="">
                </div>
                <div class="overflow-all">
                    <p class="text-uper fs-15 fontSFUBold">{{$product->name}}</p>

                    <p class="product-type text-uper fontSFURe fs-13 mgB-10">{{$product->color}}</p>

                    <p class="pull-right fontSFUBold fs-12">đ {{number_format($subtotalProduct)}}</p>

                    <p class="text-uper fontSFUBold fs-12">Size: {{$product->size()}} - Quantity: {{$item['quantity']}}</p>
                </div>
            </a>
        @endforeach
    </div>
    <div class="clearfix mgB-20">
        <span class="text-uper fs-14 fontSFUMeBold">Tạm tính</span>

        <p class="pull-right product-price">đ {{number_format($subtotal)}}</p>
    </div>
    <div class="text-center">
        <p class="fontSFURe fs-15 mgB-15">Phí vận chuyển và thuế sẽ tính lúc thanh toán</p>
        <a href="{{route('product.checkout', ['step'=>\App\Models\Frontend\ShopProduct::CHECKOUT_PRODUCTS])}}" class="text-uper btn-checkout fontSFUL">Thanh toán</a>
    </div>
@else
    <div class="text-center">
        <p class="fontSFURe fs-15 mgB-15">Không có sản phẩm nào !</p>
    </div>
@endif
