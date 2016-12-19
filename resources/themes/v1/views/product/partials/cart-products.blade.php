<?php
$subtotal = 0;
$tax = 0;
$total = 0;
?>
<div class="wrap-products">
    <div class="text-center">
        <h2>Đơn hàng</h2>
    </div>

    <table class="table table-hover">
        <thead>
        <tr>
            <th>Sản phẩm</th>
            <th>Size</th>
            <th>Số lượng</th>
            <th class="text-center">Giá</th>
            <th class="text-center">Tổng</th>
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
            <tr>
                <td class="col-md-9"><em>{{$product->name}}</em></td>
                <td class="col-md-1" style="text-align: center"> {{$product->size()}} </td>
                <td class="col-md-1" style="text-align: center"> {{$item['quantity']}} </td>
                <td class="col-md-1 text-center">{{number_format($price)}}</td>
                <td class="col-md-1 text-center">{{number_format($subtotalProduct)}}</td>
            </tr>
        @endforeach
        <tr>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td class="text-right">
                <p>
                    <strong>Subtotal: </strong>
                </p>

                <p>
                    <strong>Tax: </strong>
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
        </tr>
        <tr>
            <td>  </td>
            <td>  </td>
            <td>  </td>
            <td class="text-right"><h4><strong>Total: </strong></h4></td>
            <td class="text-center text-danger"><h4><strong>{{number_format($subtotal-$tax)}}</strong></h4></td>
        </tr>
        </tbody>
    </table>
</div>