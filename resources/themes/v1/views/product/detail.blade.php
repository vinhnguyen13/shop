@extends('layouts.app')

@section('content')
    <?php
    $images = $product->images;
    $sizes = $product->sizes;
    $quantities = [1,2,3,4,5,6,7,8,9,10];
    ?>
    <div class="container detail">
        <div class="row">
            @if (!empty($images) && count($images) > 0)
            <div class="detail__img col-sm-8">
                <div class="slidedetailpage">
                    @foreach($images as $image)
                        <div class="slidedetail__item">
                            <img src="{{$image->url('large')}}" alt="" />
                        </div>
                    @endforeach
                </div>
                <div class="slidedetail__pagi"></div>
            </div>
            @endif
            <div class="col-sm-4 detail__desc">
                <ul class="breakgum clearfix">
                    <li><a href="{{url('/')}}">home</a></li>
                    <li><span>/</span></li>
                    <li><a href="{{route('product.category', ['category'=>'footwear'])}}">footwear</a></li>
                    <li><span>/</span></li>
                    <li>{{$product->name}}</li>
                </ul>
                <p class="text-uper fontSFUL lh-30 fs-40 mgB-10">{{$product->manufacturer->name}}</p>
                <p class="text-uper fontSFUMeBold fs-40 mgB-0">{{$product->name}}</p>
                <div class="mgB-20">
                    <div class="dropdown">
                        <form id="frmAddCart" method="POST">
                            @if (!empty($sizes))
                            <a href="" class="val-selected clearfix"><span class="icon-chevron-thin-down"></span><div class="get-val">choose your size</div></a>
                            <div class="dropdown-up-style hide">
                                <div class="dropdown__inner">
                                    <ul>
                                        @foreach($sizes as $size)
                                            <li><a href=""><span class="pull-right detail__price" data-value="{{$size->getPrice()}}">{{number_format($size->getPrice())}} đ</span><span class="detail__size" data-value="{{$size->id}}">{{$size->size}}</span></a></li>
                                        @endforeach
                                    </ul>
                                    <input type="hidden" name="size" id="val-size" value="">
                                    <input type="hidden" name="price" id="val-price" value="">
                                    <input type="hidden" name="quantity" value="1">
                                </div>
                            </div>
                            @endif
                        </form>
                    </div>
                    <button type="submit" class="btn-buy text-uper">add to cart</button>
                </div>
                <div class="detail__desc--intro">
                    <p class="title__detailproduct">Detail</p>
                    <p>{!! $product->description !!}</p>
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
    <script type="text/javascript" src="/themes/v1/js/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript" src="/themes/v1/js/jquery.lazyload.js"></script>
    <script>
        var urlAddCart = "{{route('product.cart.add')}}";
        var dataRequest = "{{encrypt($product->id)}}";
    </script>
    <script type="text/javascript" src="{!! asset('js/front/product.js')  !!}"></script>
@endpush