@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout">
        <div class="checkout__inner clearfix">
            <form id="orderForm" action="{{route('product.checkout', ['step'=>$step])}}" method="post">
            {{ csrf_field() }}
            @if(!empty($cart))
            <div class="checkout__inforpro">
                @include('product.checkout.partials.products')
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
                @include('product.checkout.partials.'.$view)
            </div>
            @else
                <div class="alert alert-info fade in alert-dismissable">
                    <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
                    Không có sản phẩm nào trong giỏ hàng.
                </div>
                <a href="{{url('/')}}" class="btn btn-block btn-success">Tiếp tục mua hàng</a>
            @endif
            </form>
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
        var urlLocation = "{{route('home.location')}}";
    </script>
    <script src="{!! asset('js/front/checkout.js')  !!}"></script>
@endpush