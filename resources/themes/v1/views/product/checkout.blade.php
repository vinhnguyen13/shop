@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout">
        <div class="checkout__inner clearfix">
            @if(!empty($cart))
            <div class="checkout__inforpro">
                @include('product.partials.checkout-products')
            </div>
            <div class="checkout__infor">
                <div class="clearfix">
                    <p class="checkout__infor--date">DATE : {{date('d F, Y')}}</p>
                    <div class="checkout__infor--addpress">
                        <p class="fontSFUBold letter-2">GLAB.VN</p>
                        <p class="fontSFURe letter-1">135/58 Trần Hưng Đạo , Quận 1<br>
                            HCM city , Việt Nam .</p>
                        <p class="fontSFURe">glab.vn@gmail.com</p>
                        <p class="fontSFURe">094 537 88 09</p>
                    </div>
                </div>
                @include('product.partials.checkout-info')
                @include('product.partials.checkout-payment')
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
        var urlUpdateCart = "{{route('product.cart.update')}}";
        var urlAddCart = "{{route('product.cart.add')}}";
        var urlOrder = "{{route('product.order')}}";
        var urlLocation = "{{route('home.location')}}";
        var urlPaymentSuccess = "{{route('product.payment.success')}}";
        var urlPaymentFail = "{{route('product.payment.fail')}}";
    </script>
    <script src="{!! asset('js/front/checkout.js')  !!}"></script>
@endpush