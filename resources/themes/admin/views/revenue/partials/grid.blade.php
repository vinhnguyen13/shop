@if(!empty($orders))
    <?php
    $paymentTotal = 0;
    $revenueTotal = 0;
    $consignmentPaymentTotal = 0;
    ?>
    <table class="table table-bordered">
        <tbody><tr>
            <th style="width: 10px">ID</th>
            <th>Date</th>
            <th>SKU</th>
            <th>Supplier</th>
            <th>Product</th>
            <th>Size</th>
            <th>QTY</th>
            <th>Price</th>
            <th>Payment</th>
            <th>Revenue</th>
            <th>Consignment Payment</th>
        </tr>
        @foreach($orders as $order)
            <?php
            $date = date('d-m-Y', strtotime($order->order->created_at));
            $supplierHtml = '<a href="'.route('admin.supplier.index', ['id'=>$order->supplier_id]).'">'.$order->supplier->name.'</a><br>';
            $supplierHtml .= '<p class="help-block small">Discount: '.number_format($order->supplier->discount_available).' %</p>';
            $priceHtml = number_format($order->price).'<br/>';
            $priceHtml .= '<p class="help-block small">Price In: '.number_format($order->price_in).'</p>';
            $revenue = $order->total * $order->supplier->discount_available / 100;
            $revenueHtml = number_format($revenue);
            $consignmentPayment = $order->total - $revenue;
            $consignmentPaymentHtml = number_format($consignmentPayment);
            $consignmentPaymentHtml .= '<p class="help-block small">Payment Date: '.date('d-m-Y', strtotime('+5 days', strtotime($order->order->created_at))).'</p>';
            $paymentTotal += $order->total;
            $revenueTotal += $revenue;
            $consignmentPaymentTotal += $consignmentPayment;
            ?>
            <tr>
                <td>{{$order->id}}</td>
                <td>{{$date}}</td>
                <td>{{$order->sku}}</td>
                <td>{!! $supplierHtml !!}</td>
                <td>{{$order->product_name}}</td>
                <td>{{$order->size}}</td>
                <td>{{$order->quantity}}</td>
                <td>{!! $priceHtml !!}</td>
                <td>{{number_format($order->total)}}</td>
                <td>{!! $revenueHtml !!}</td>
                <td>{!! $consignmentPaymentHtml !!}</td>
            </tr>
        @endforeach
        <tr>
            <td colspan="8" class="text-right text-bold">Total</td>
            <td class="text-bold">{{number_format($paymentTotal)}}</td>
            <td class="text-bold">{{number_format($revenueTotal)}}</td>
            <td class="text-bold">{{number_format($consignmentPaymentTotal)}}</td>
        </tr>
        </tbody>
    </table>
    <div class="pagination pagination-sm no-margin pull-right">
        {{ $orders->links('vendor.pagination.default') }}
    </div>
@endif