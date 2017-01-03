@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout">
        <div class="row">
            @if(!empty($cart))
            <div class="well col-md-10 col-md-offset-1">
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

                <div class="row">
                    <form method="post" action="" class="form-horizontal" id="orderForm">
                        {{ csrf_field() }}
                        @include('product.partials.cart-products')
                        @include('product.partials.cart-shipping')
                        @include('product.partials.cart-billing')
                        @include('product.partials.cart-payment')
                        <div class="form-group">
                            <div class="col-md-12 text-right">
                                <button type="button" class="btn btn-primary btn-lg btn-checkout btn-back hide">Trở lại</button>
                                <button type="submit" class="btn btn-primary btn-lg btn-checkout btn-order">Đặt hàng</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            @else
                <div class="col-sm-6 col-sm-offset-3">
                    <div class="alert alert-info fade in alert-dismissable">
                        <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
                        Không có sản phẩm nào trong giỏ hàng.
                    </div>
                    <a href="{{url('/')}}" class="btn btn-block btn-success">Tiếp tục mua hàng</a>
                </div>
            @endif
        </div>
    </div>

@endsection

@push('styles')
    <link href="{!! asset('css/front/checkout.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        var urlRemoveCart = "{{route('product.cart.remove')}}";
        var urlOrder = "{{route('product.order')}}";
    </script>
    <script src="{!! asset('js/front/checkout.js')  !!}"></script>
@endpush