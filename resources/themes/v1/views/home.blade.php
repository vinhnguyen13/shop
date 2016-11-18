@extends('layouts.app')

@section('content')
        <!-- InstanceBeginEditable name="content" -->
<div class="swiper-container slidehomepage">
    <div class="swiper-wrapper">
        <div class="swiper-slide wrap-img">
            <img src="/themes/v1/images/img-slide-1.jpg" alt="" />
            <div class="desc">
                <h2>air force i</h2>
                <a href="" class="btn">shop now</a>
            </div>
        </div>
        <div class="swiper-slide wrap-img">
            <img src="/themes/v1/images/img-slide-2.jpg" alt="" />
            <div class="desc">
                <h2>air force i</h2>
                <a href="" class="btn">shop now</a>
            </div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<div class="container">
    <div class="row products">
        @include('product.partials.item')
    </div>
    <div class="text-center">
        <a href="{{route('product.index')}}" class="btn-see-more text-uper">see more</a>
    </div>
</div>
<div class="container">
    <div class="row products">
        @include('product.partials.item')
    </div>
    <div class="text-center">
        <a href="{{route('product.index')}}" class="btn-see-more text-uper">see more</a>
    </div>
</div>
<div class="swiper-container slidehomepage">
    <div class="swiper-wrapper">
        <div class="swiper-slide wrap-img">
            <img src="/themes/v1/images/img-slide-1.jpg" alt="" />
            <div class="desc">
                <h2>air force i</h2>
                <a href="" class="btn">shop now</a>
            </div>
        </div>
        <div class="swiper-slide wrap-img">
            <img src="/themes/v1/images/img-slide-2.jpg" alt="" />
            <div class="desc">
                <h2>air force i</h2>
                <a href="" class="btn">shop now</a>
            </div>
        </div>
    </div>
    <div class="swiper-pagination"></div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<div class="connect container mgT-100">
    <div class="text-center mgB-60">
        <span class="d-ib text-uper fontSFUBold fs-25 mgR-60 connect__title">connect us</span>
        <a href="" class="mgR-20 fs-20"><span class="icon-facebook"></span></a>
        <a href="" class="mgR-20 fs-20"><span class="icon-306026"></span></a>
        <a href="" class="mgR-20 fs-20"><span class="icon-play"></span></a>
    </div>
    <div class="connect__items clearfix">
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
        <div class="connect__items--item">
            <a href="">
                <span class="icon-306026 fs-30"></span>
            </a>
        </div>
    </div>
</div>
<!-- InstanceEndEditable -->
@endsection

@push('styles')
    <link rel="stylesheet" href="/themes/v1/css/swiper.min.css">
@endpush

@push('scripts')
    <script type="text/javascript" src="/themes/v1/js/jquery.lazyload.js"></script>
    <script type="text/javascript" src="/themes/v1/js/swiper.jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $("img.lazy").lazyload({
                effect : "fadeIn"
            });

            var swiper = new Swiper('.slidehomepage', {
                pagination: '.swiper-pagination',
                paginationClickable: true,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                autoplay: 4000
            });
        });
    </script>
@endpush