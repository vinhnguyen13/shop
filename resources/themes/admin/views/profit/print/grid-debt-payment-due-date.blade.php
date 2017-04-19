@extends('layouts.print')

@section('content')
    <div class="print__a5">
        <div class="clearfix mgB-15">
            <div class="pull-left">
                <p class="fontSFUMeBold fs-17 lh-50 mgT-10">PAYMENT NO #:</p>
            </div>
            <div class="pull-right text-right">
                <div class="mgB-10"><img src="icons/logo-footer.svg" alt="" width="80"></div>
                <p class="fontSFUMeBold fs-14">135/58 Trần Hưng Đạo , District 1, HCM city , Việt Nam</p>
                <p class="fontSFUMeBold fs-14">glab.vn@gmail.com  -   094 537 88 09</p>
            </div>
        </div>
        <p class="fontSFURe text-center fs-17 mgB-10 font-600">CUSTOMER INFO</p>
        <div class="mgB-5">
            <span class="d-ib w-32 fontSFUMeBold">DATE:</span>
            <span class="d-ib w-32 fontSFUMeBold">NAME:</span>
            <span class="d-ib w-32 fontSFUMeBold">CMND:</span>
        </div>
        <div class="mgB-5">
            <span class="d-ib w-32 fontSFUMeBold">TIME:</span>
            <span class="d-ib w-32 fontSFUMeBold">EMAIL:</span>
            <span class="d-ib w-32 fontSFUMeBold">ADDRESS:</span>
        </div>
        <div class="mgB-15">
            <span class="d-ib w-32 fontSFUMeBold">STAFF:</span>
            <span class="d-ib w-32 fontSFUMeBold">PHONE:</span>
        </div>
        @if(!empty($orders))
            <?php
            $paymentTotal = 0;
            $revenueTotal = 0;
            $consignmentPaymentTotal = 0;
            $num = 1;
            ?>
            <table>
                <thead><tr>
                    <th class="w-5 fontSFURe text-center font-600">ID</th>
                    <th class="w-15">
                        <p class="fontSFURe font-600">SALEDATE</p>
                        <p class="fontSFURe color-7c7c7c fs-11">(IMPORT DATE)</p>
                    </th>
                    <td class="w-40"><p class="fontSFURe font-600">PRODUCT </p></td>
                    <td class="w-5 text-center"><p class="fontSFURe font-600">SIZE</p></td>
                    <td class="w-5 text-center"><p class="fontSFURe font-600">QTY</p></td>
                    <td class="text-right w-25">
                        <p class="fontSFURe font-600">CONSIGNMENT PAYMENT</p>
                        <p class="fontSFURe color-7c7c7c fs-11">PRICE</p>
                    </td>
                </tr>
                </thead>
                <tbody>
                @foreach($orders as $order)
                    <?php
                    $date1 = date('d-m-Y', strtotime($order->created_at));
                    $date2 = date('d-m-Y', strtotime('+'.\App\Models\ShopProductDetail::DUE_DAYS.' days', strtotime($order->created_at)));
                    $revenue = $order->supplier->consignmentFeeValue($order->total);
                    $consignmentPayment = $order->total - $revenue;
                    $consignment1 = number_format($consignmentPayment);
                    $consignment2 = number_format($order->price);
                    $paymentTotal += $order->total;
                    $revenueTotal += $revenue;
                    $consignmentPaymentTotal += $consignmentPayment;
                    ?>
                    <tr>
                        <td class="fontSFURe text-center font-600"><p>{{$num}}</p></td>
                        <td>
                            <p class="fontSFUMeBold font-600 fs-12">{{$date1}}</p>
                            <p class="fontSFUMeBold color-7c7c7c fs-11">{{$date2}}</p>
                        </td>
                        <td>
                            <p class="fontSFUMeBold">{{$order->product_name}}  (SKU : {{$order->sku}})</p>
                        </td>
                        <td class="text-center"><p class="fontSFUMeBold">{{$order->size}}</p></td>
                        <td class="text-center"><p class="fontSFUMeBold">{{$order->quantity}}</p></td>
                        <td class="text-right">
                            <p class="fontSFUMeBold">{{$consignment1}}</p>
                            <p class="fontSFUMeBold color-7c7c7c fs-11">{{$consignment2}}</p>
                        </td>
                    </tr>
                    <?php
                    $num++;
                    ?>
                @endforeach
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-center"><p class="fontSFURe font-600 fs-16">TOTAL</p></td>
                    <td class="text-right"><p class="fontSFURe font-600 fs-16">{{number_format($consignmentPaymentTotal)}} đ</p></td>
                </tr>
                <tr>
                    <td></td>
                    <td><p class="fontSFUMeBold font-600 fs-15">G-LAB</p></td>
                    <td><p class="fontSFUMeBold font-600 fs-15">CUSTOMER</p></td>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                </tbody>
            </table>
        @endif
    </div>
@endsection