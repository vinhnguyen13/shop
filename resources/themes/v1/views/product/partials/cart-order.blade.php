<div class="checkout__infor">
    <p class="font-bold mgB-10">Địa chỉ giao hàng/Thanh toán</p>
    <p>Trương Hoàng Điển</p>
    <p>21 Nguyễn Trung Ngạn</p>
    <p>Hồ Chí Minh-Quận 1</p>
    <p>Điện thoại di động: 0905296128</p>
    <p class="mgT-20 font-bold mgB-10">Thông tin đơn hàng</p>
    <table class="table fs-12">
        <tbody><tr>
            <th class="w-45">SẢN PHẨM</th>
            <th>SỐ LƯỢNG</th>
            <th>GIÁ</th>
        </tr>
        <tr>
        <?php
        $subtotal = 0;
        $tax = 0;
        $total = 0;
        $quantities =[1=>1,2,3,4,5,6,7,8,9,10];
        ?>
        @foreach($cart as $item)
            <?php
            $product = App\Models\Frontend\ShopProduct::find($item['product_id']);
            $product->setCart($item['size'], $item['quantity']);
            $price = $product->priceWithSize();
            $subtotalProduct = $price * $item['quantity'];
            $subtotal += $subtotalProduct;
            $tax += $product->taxWithPrice($price);
            ?>
            <tr data-product-id="{{encrypt($product->id)}}">
                <td class="col-md-9"><a href="{{$product->url()}}"><em>{{$product->name}}</em></a></td>
                <td class="col-md-1" style="text-align: center">
                    {!! Form::select('payment_bank', $quantities, $item['quantity'], ['class' => 'w-100']) !!}
                    <p class="text-center mgT-5"><a href="" class="text-decor fs-12 removeCart">xóa</a></p>
                </td>
                <td class="col-md-1 text-center">{{number_format($subtotalProduct)}}</td>
            </tr>
        @endforeach
        </tr>
        <tr>
            <td colspan="2" class="font-bold">Tạm tính</td>
            <td>{{number_format($subtotal)}} VND</td>
        </tr>
        <tr>
            <td colspan="2" class="font-bold">Phí vận chuyển</td>
            <td>Miễn phí</td>
        </tr>
        <tr>
            <td colspan="2" class="font-bold">
                Thành tiền
                <p>(Tổng số tiền thanh toán)</p>
            </td>
            <td class="text-danger font-bold fs-13">{{number_format($subtotal-$tax)}} VND</td>
        </tr>
        </tbody></table>
</div>