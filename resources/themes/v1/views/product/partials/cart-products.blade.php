<?php
$subtotal = 0;
$tax = 0;
$total = 0;
?>
<div class="step-checkout hide" id="wrap-products">
    <div class="text-center">
        <h2>Đơn hàng của quý khách</h2>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Size</th>
            <th>Số lượng</th>
            <th class="text-center">Giá</th>
            <th class="text-center">Tổng</th>
            <th class="text-center">&nbsp;</th>
        </tr>
        </thead>
        <tbody>
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
                <td class="col-md-9"><em>{{$product->name}}</em></td>
                <td class="col-md-1" style="text-align: center"> {{$product->size()}} </td>
                <td class="col-md-1" style="text-align: center"> {{$item['quantity']}} </td>
                <td class="col-md-1 text-center">{{number_format($price)}}</td>
                <td class="col-md-1 text-center">{{number_format($subtotalProduct)}}</td>
                <td class="col-md-1 text-center"><a href="javascript:;" class="removeCart"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></td>
            </tr>
        @endforeach
        <tr>
            <td colspan="4" class="text-right">
                <p>
                    <strong>Tạm tính: </strong>
                </p>

                <p>
                    <strong>Thuế: </strong>
                </p>
            </td>
            <td class="text-center">
                <p>
                    <strong>{{number_format($subtotal)}}</strong>
                </p>

                <p>
                    <strong>{{number_format($tax)}}</strong>
                </p>
            </td>
            <td>  </td>
        </tr>
        <tr>
            <td colspan="4" class="text-right"><h4><strong>Thành tiền (Tổng số tiền thanh toán): </strong></h4></td>
            <td class="text-center text-danger"><h4><strong>{{number_format($subtotal-$tax)}}</strong></h4></td>
            <td>  </td>
        </tr>
        </tbody>
    </table>
</div>