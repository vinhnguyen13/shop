@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6">
                    <address>
                        <strong>Elf Cafe</strong>
                        <br>
                        2135 Sunset Blvd
                        <br>
                        Los Angeles, CA 90026
                        <br>
                        <abbr title="Phone">P:</abbr> (213) 484-6829
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                        <em>Date: {{date('D F, Y')}}</em>
                    </p>
                    <p>
                        <em>Receipt #: 34522677W</em>
                    </p>
                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <h1>Receipt</h1>
                </div>
                </span>
                @if(!empty($cart))
                    <?php
                    $subtotal = 0;
                    $tax = 0;
                    $total = 0;
                    ?>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Product</th>
                        <th>Size</th>
                        <th>Quantity</th>
                        <th class="text-center">Price</th>
                        <th class="text-center">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                        @foreach($cart as $item)
                            <?php
                            $product = App\Models\Frontend\ShopProduct::find($item['product_id']);
                            $size = App\Models\Frontend\ShopProductSize::find($item['size']);
                            $price = $size->price();
                            $subtotalProduct = $price * $item['quantity'];
                            $subtotal += $subtotalProduct;
                            ?>
                            <tr>
                                <td class="col-md-9"><em>{{$product->name}}</em></td>
                                <td class="col-md-1" style="text-align: center"> {{$size->size}} </td>
                                <td class="col-md-1" style="text-align: center"> {{$item['quantity']}} </td>
                                <td class="col-md-1 text-center">{{number_format($price)}}</td>
                                <td class="col-md-1 text-center">{{number_format($subtotalProduct)}}</td>
                            </tr>
                        @endforeach
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
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
                                <strong>{{$tax}}</strong>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td>   </td>
                        <td>   </td>
                        <td>   </td>
                        <td class="text-right"><h4><strong>Total: </strong></h4></td>
                        <td class="text-center text-danger"><h4><strong>{{number_format($subtotal-$tax)}}</strong></h4></td>
                    </tr>
                    </tbody>
                </table>
                @endif
                <button type="button" class="btn btn-success btn-lg btn-block">
                    Pay Now   <span class="glyphicon glyphicon-chevron-right"></span>
                </button></td>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')

@endpush

@push('scripts')

@endpush