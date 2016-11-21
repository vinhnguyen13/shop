@extends('layouts.app')

@section('content')
    <div class="container detail">
        <div class="row">
            <div class="detail__img col-sm-6">
                <div class="swiper-container slidedetailpage">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <img src="images/310x177.jpg" alt="" />
                        </div>
                        <div class="swiper-slide">
                            <img src="images/315x321.jpg" alt="" />
                        </div>
                        <div class="swiper-slide">
                            <img src="images/310x177.jpg" alt="" />
                        </div>
                        <div class="swiper-slide">
                            <img src="images/315x321.jpg" alt="" />
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
                <div class="detail__img--thumb">
                    <ul>
                        <li><a href=""><img src="images/310x177.jpg" alt="" /></a></li>
                        <li><a href=""><img src="images/315x321.jpg" alt="" /></a></li>
                        <li><a href=""><img src="images/310x177.jpg" alt="" /></a></li>
                        <li><a href=""><img src="images/315x321.jpg" alt="" /></a></li>
                    </ul>
                </div>
            </div>
            <div class="col-sm-6 detail__desc">
                <h1 class="text-uper fontSFUMeBold fs-40 mgB-0">nike air more uptempo</h1>
                <p class="text-uper fontSFUL fs-20 mgB-5">white/gum (sku: 493982-102)</p>
                <p class="fontSFUBold fs-20 mgB-15">đ 6.500.000</p>
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
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    <p>Lorem ipsum dolor</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit</p>
                    <p>Lorem ipsum dolor</p>
                </div>
                <div class="detail__desc--param">
                    <p>Style: 939822-102</p>
                    <p>Color: <span class="text-uper">white gum</span></p>
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

@endpush

@push('scripts')

@endpush