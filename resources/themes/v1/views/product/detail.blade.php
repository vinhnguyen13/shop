@extends('layouts.app')

@section('content')
    <div class="container detail">
        <div class="row">
            <div class="detail__img col-sm-6">
                <?php
                $images = $product->images;
                $sizes = $product->sizes;
                $quantities = [1,2,3,4,5,6,7,8,9,10];
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
                    <form id="frmAddCart" method="POST">
                    @if (!empty($sizes))
                    <div class="col-xs-12 col-sm-5 mgB-10">
                        <p class="text-uper fontSFUMeBold mgB-5">size us</p>
                        <select name="size" id="size" class="w-100">
                            @foreach($sizes as $size)
                                <option value="{{$size->id}}">{{$size->size}}</option>
                            @endforeach
                        </select>
                    </div>
                    @endif
                    <div class="col-xs-6 col-sm-3">
                        <p class="text-uper fontSFUMeBold mgB-5">Số lượng</p>
                        @if (!empty($quantities))
                        <select name="quantity" id="quantity" class="w-100">
                            @foreach($quantities as $quantity)
                                <option value="{{$quantity}}">{{$quantity}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="col-xs-6 col-sm-4">
                        <button type="submit" class="btn-buy text-uper">buy now</button>
                    </div>
                    </form>
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
            @include('product.partials.list-items')
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/themes/v1/css/swiper.min.css">
@endpush

@push('scripts')
    <script type="text/javascript" src="/themes/v1/js/jquery.lazyload.js"></script>
    <script type="text/javascript" src="/themes/v1/js/swiper.jquery.min.js"></script>
    <script>
        var urlAddCart = "{{route('product.addCart')}}";
        var dataRequest = "{{encrypt($product->id)}}";
    </script>
    <script type="text/javascript" src="/themes/v1/js/product.js"></script>
@endpush