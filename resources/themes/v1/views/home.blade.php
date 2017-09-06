@extends('layouts.app')

@section('content')
        <!-- InstanceBeginEditable name="content" -->
<div class="swiper-container slidehomepage slidehomepage-1">
    <div class="swiper-wrapper">
        <div class="swiper-slide wrap-img">
            <img src="/themes/v1/images/img-slide-1.jpg" alt="" />
            <div class="desc">
                <h2>NIKE AIR JORDAN 11 PRM COOL GREY <br> NOW AVAILABLE</h2>
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
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<div class="container">
    @include('product.main.partials.list-items', ['products'=>$footwears])
</div>
<div class="swiper-container slidehomepage slidehomepage-2">
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
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<div class="container">
    @include('product.main.partials.list-items', ['products'=>$apparels])
</div>
<div class="swiper-container slidehomepage slidehomepage--last">
    <div class="swiper-wrapper">
        <div class="swiper-slide wrap-img">
            <img src="/themes/v1/images/d-s-c-01558.jpg" alt="" />
            <div class="desc">
                <h2>WE REPRESENT THE SNEAKER CULTURE <br> BLOW YOUR MIND</h2>
                <a href="" class="btn">READ NOW</a>
            </div>
        </div>
        <div class="swiper-slide wrap-img">
            <img src="/themes/v1/images/img-slide-2.jpg" alt="" />
            <div class="desc">
                <h2>WE REPRESENT THE SNEAKER CULTURE <br> BLOW YOUR MIND</h2>
                <a href="" class="btn">READ NOW</a>
            </div>
        </div>
    </div>
    <div class="swiper-button-next"></div>
    <div class="swiper-button-prev"></div>
</div>
<div class="connect container mgT-100">
    <div class="text-center mgB-60">
        <span class="d-ib text-uper font-600 fs-30 mgR-60 connect__title">connect us</span>
        <a href="" class="mgR-20 fs-30"><span class="icon-facebook2"></span></a>
        <a href="" class="mgR-30 fs-30"><span class="icon-306026"></span></a>
        <a href="" class="fs-30"><span class="icon-play"></span></a>
    </div>
    <div class="connect__items">
        <?php
        $url = 'https://www.instagram.com/glab.vn/media/';
        $content = file_get_contents($url);
        $obj = \GuzzleHttp\json_decode($content);
        if(!empty($obj->items)){
            foreach($obj->items as $key => $item){
                if($key <= 9){
                $link = $item->link;
                $url = 'https://scontent.cdninstagram.com/t51.2885-15/s640x640/sh0.08/e35/17076978_1652568568371454_5195433053899456512_n.jpg';
                if(!empty($item->images->standard_resolution->url)){
                    $url = $item->images->standard_resolution->url;
                }
                ?>
                <div class="connect__items--item">
                    <a href="{{$link}}" target="_blank">
                        <span class="icon-306026 fs-30"></span>
                        <div class="wrap-img"><img src="{{$url}}" alt="" /></div>
                    </a>
                </div>
                <?php
                }
            }
        }
        ?>
    </div>
</div>
<!-- InstanceEndEditable -->
@endsection

@push('styles')
    <link rel="stylesheet" href="/themes/v1/css/swiper.min.css">
@endpush

@push('scripts')
    <script type="text/javascript" src="/themes/v1/js/swiper.jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var swiper = new Swiper('.slidehomepage', {
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                loop: true
            });
        });
    </script>
@endpush