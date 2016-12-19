@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="well col-xs-10 col-sm-10 col-md-6 col-xs-offset-1 col-sm-offset-1 col-md-offset-3">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6">
                        <address>
                            <strong>Glab.VN</strong>
                            <br>
                            135/58 Trần Hưng Đạo, Quận 1,
                            <br>
                            Ho Chi Minh City, Vietnam
                            <br>
                            <abbr title="Phone">M:</abbr> 094 537 88 09
                        </address>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                        <p>
                            <em>Date: {{date('D F, Y')}}</em>
                        </p>
                    </div>
                </div>
                @if(!empty($cart))
                    <?php
                    $subtotal = 0;
                    $tax = 0;
                    $total = 0;
                    ?>
                    <div class="row">
                        <div class="text-center">
                            <h1>Receipt</h1>
                        </div>

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
                                <td class="text-center text-danger"><h4>
                                        <strong>{{number_format($subtotal-$tax)}}</strong></h4></td>
                            </tr>
                            </tbody>
                        </table>

                        <button type="button" class="btn btn-success btn-lg btn-block">
                            Pay Now   <span class="glyphicon glyphicon-chevron-right"></span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>

@endsection

@push('styles')

@endpush

@push('scripts')

@endpush