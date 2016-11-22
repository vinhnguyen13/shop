@extends('layouts.app')

@section('content')
    <div class="container detail">
        <div class="row">
            <div class="detail__img col-sm-6">
                <?php
                $images = $product->images;
                ?>
                @if (!empty($images) && count($images) > 0)
                <div class="swiper-container slidedetailpage">
                    <div class="swiper-wrapper">
                            @foreach($images as $image)
                                <div class="swiper-slide">
                                    <img src="{{$image->url()}}" alt="" />
                                </div>
                            @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>

                <div class="detail__img--thumb">
                    <ul>
                        @foreach($images as $image)
                            <li><a href=""><img src="{{$image->url()}}" alt="" /></a></li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="col-sm-6 detail__desc">
                <h1 class="text-uper fontSFUMeBold fs-40 mgB-0">{{$product->name}}</h1>
                <p class="text-uper fontSFUL fs-20 mgB-5">white/gum (sku: {{$product->sku}})</p>
                <p class="fontSFUBold fs-20 mgB-15">vnđ {{number_format($product->price, 0)}}</p>
                <div class="row mgB-25">
                    <div class="col-xs-12 col-sm-5 mgB-10">
                        <p class="text-uper fontSFUMeBold mgB-5">size us</p>
                        <select name="" id="" class="w-100">
                            <option value="">8 US</option>
                            <option value="">8 US</option>
                            <option value="">8 US</option>
                            <option value="">8 US</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-3">
                        <p class="text-uper fontSFUMeBold mgB-5">Số lượng</p>
                        <select name="" id="" class="w-100">
                            <option value="">1</option>
                            <option value="">1</option>
                            <option value="">1</option>
                            <option value="">1</option>
                        </select>
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <button type="submit" class="btn-buy text-uper">buy now</button>
                    </div>
                </div>
                <div class="detail__desc--intro">
                    {!! $product->description !!}
                </div>
                <div class="detail__desc--param">
                    <p>Style: 939822-102</p>
                    <p>Color: <span class="text-uper">{{$product->color}}</span></p>
                    <p>Material: <span class="text-uper">leather</span></p>
                </div>
            </div>
        </div>
        <div class="detail__related">
            <div class="text-center text-uper fontSFUBold fs-25">related products</div>
            @include('product.partials.item')
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/themes/v1/css/swiper.min.css">
@endpush

@push('scripts')
    <script type="text/javascript" src="/themes/v1/js/jquery.lazyload.js"></script>
    <script type="text/javascript" src="/themes/v1/js/swiper.jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            var swiper = new Swiper('.slidedetailpage', {
                pagination: '.swiper-pagination',
                paginationClickable: true,
                nextButton: '.swiper-button-next',
                prevButton: '.swiper-button-prev',
                onSlideChangeStart: function (swiper) {
                    $('.detail__img--thumb li').removeClass('active');
                    $('.detail__img--thumb li').eq(swiper.activeIndex).addClass('active');
                }
            });
            $('.detail__img--thumb li').eq(0).addClass('active');
            $('.detail__img--thumb li a').on('click', function (e) {
                e.preventDefault();
                var i = $(this).parent().index();
                $('.detail__img--thumb li').removeClass('active');
                $(this).parent().addClass('active');
                swiper.slideTo(i);
            });

            $("img.lazy").lazyload({
                effect : "fadeIn"
            });
        });
    </script>
@endpush