@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout">
        <div class="checkout__inner">
            @if(!empty($cart))
                <div class="clearfix mgB-20">
                    <p class="pull-right">Date: {{date('D F, Y')}}</p>
                    <p class="fontSFUBold fs-15">Glab.VN</p>
                    <p>135/58 Trần Hưng Đạo, Quận 1, <br> Ho Chi Minh City, Vietnam </p>
                    <p>ĐT: 094 537 88 09</p>
                </div>


                <div class="row mgB-20 mgT-5">
                    <div class="col-md-7">
                        <form method="post" action="" class="form-horizontal" id="orderForm">
                            {{ csrf_field() }}
                            {{--@include('product.partials.cart-products')--}}
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
                    <div class="col-md-5">
                        @include('product.partials.cart-order')
                    </div>
                </div>
            @else
                <div class="alert alert-info fade in alert-dismissable">
                    <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
                    Không có sản phẩm nào trong giỏ hàng.
                </div>
                <a href="{{url('/')}}" class="btn btn-block btn-success">Tiếp tục mua hàng</a>
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
        var urlLocation = "{{route('home.location')}}";
        var urlPaymentSuccess = "{{route('product.payment.success')}}";
        var urlPaymentFail = "{{route('product.payment.fail')}}";
    </script>
    <script src="{!! asset('js/front/checkout.js')  !!}"></script>
@endpush