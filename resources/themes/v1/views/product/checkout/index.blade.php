@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout">
        <div class="text-center mgB-50">
            <ul class="breakcum">
                <li><a href="">CART</a></li>
                <li><span>/</span></li>
                <li><a href="">Checkouut</a></li>
            </ul>
        </div>
        <div class="checkout__inner clearfix">
            <form action="{{route('product.checkout', ['step'=>$step])}}" method="post">
            {{ csrf_field() }}
            @if(!empty($cart))
            <div class="checkout__infor">
                @include('product.checkout.partials.'.$view)
            </div>
            <div class="checkout__inforpro">
                @include('product.checkout.partials.products')
            </div>
            @else
                <div class="alert alert-info fade in alert-dismissable">
                    <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
                    Không có sản phẩm nào trong giỏ hàng.
                </div>
                <a href="{{url('/')}}" class="btn btn-glab btn-block btn-success">Tiếp tục mua hàng</a>
            @endif
            </form>
        </div>
    </div>
@endsection

@push('styles')
    <link href="{!! asset('css/front/checkout.css') !!}" rel="stylesheet">
    <link href="{!! asset('https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css') !!}" rel="stylesheet">
    <style>
        input[type='text'].ui-autocomplete-loading {
            background:  url('http://www.hsi.com.hk/HSI-Net/pages/images/en/share/ajax-loader.gif') no-repeat right center;
        }
    </style>
@endpush

@push('scripts')
    <script>
        var urlRemoveCart = "{{route('product.cart.remove')}}";
        var urlUpdateCart = "{{route('product.cart.update')}}";
        var urlAddCart = "{{route('product.cart.add')}}";
        var urlLocation = "{{route('home.location')}}";
    </script>
    <script src="{!! asset('http://code.jquery.com/ui/1.11.1/jquery-ui.min.js?v='.$version_deploy)  !!}"></script>
    <script src="{!! asset('js/front/checkout.js?v='.$version_deploy)  !!}"></script>
@endpush