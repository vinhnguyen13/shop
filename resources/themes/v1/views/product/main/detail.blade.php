@extends('layouts.app')

@section('content')
    <?php
    $images = $product->images;
    $details = $product->getDetailsGroupBySize();
    $quantities = [1,2,3,4,5];
    ?>
    <div class="container detail">
        <div class="row" data-sticky_parent>
            <div class="detail__img col-sm-8" data-sticky_column>
                <ul class="breakcum">
                    <li><a href="{{url('/')}}">home</a></li>
                    <li><span>/</span></li>
                    <li><a href="{{route('product.category', ['category'=>'footwear'])}}">footwear</a></li>
                    <li><span>/</span></li>
                    <li>{{$product->name}}</li>
                </ul>
                <div class="slidedetailpage swiper-container">
                    @if (!empty($images) && count($images) > 0)
                        <div class="swiper-wrapper">
                        @foreach($images as $image)
                            <div class="slidedetail__item swiper-slide">
                                <img src="{{$image->url('original')}}" alt="" />
                            </div>
                        @endforeach
                        </div>
                        <!-- Add Pagination -->
                        <div class="swiper-pagination"></div>
                    @endif
                </div>
                <div class="slidedetail__pagi"></div>
            </div>
            <div class="col-sm-4 detail__desc" data-sticky_column>
                <div class="detail__desc--inner">
                    <div class="detail__desc--fix">
                        <ul class="breakcum">
                            <li><a href="{{url('/')}}">home</a></li>
                            <li><span>/</span></li>
                            <li><a href="{{route('product.category', ['category'=>'footwear'])}}">footwear</a></li>
                            <li><span>/</span></li>
                            <li>{{$product->name}}</li>
                        </ul>
                        <p class="text-uper font-500  lh-30 fs-24 mgB-10">{{$product->manufacturer->name or ''}}</p>
                        <p class="text-uper font-500  fs-24 mgB-0 lh-40 mgB-20">{{$product->name}}</p>
                        <div class="mgB-20">
                            <div class="dropdown">
                            @if (!empty($details) && $details->count() > 0)
                                <form id="frmAddCart" method="POST">
                                    <a href="" class="val-selected clearfix"><span class="icon-chevron-thin-down"></span><div class="get-val">choose your size</div></a>
                                    <div class="dropdown-up-style hide">
                                        <div class="dropdown__inner">
                                            <ul>
                                                @foreach($details as $detail)
                                                    @if (!empty($detail->size))
                                                        <li data-size="{{$detail->size}}"><a href=""><span class="pull-right detail__price">{{number_format($detail->getPrice())}} đ</span><span class="detail__size" data-size="{{$detail->size}}" data-product="{{encrypt($detail->product_id)}}" data-detail="{{$detail->id}}">{{$detail->size}} - {{$detail->getTextNewStatus()}}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <input type="hidden" name="size" id="val-size" value="">
                                            <input type="hidden" name="product" id="val-product" value="">
                                            <input type="hidden" name="quantity" value="1">
                                        </div>
                                    </div>
                                    <button type="submit" class="btn-buy text-uper">add to cart</button>
                                </form>
                            @else
                                <a href="" class="val-selected clearfix"><div class="get-val">out of stock</div></a>
                            @endif
                            </div>
                        </div>
                        <div class="detail__desc--intro">
                            <p class="title__detailproduct">Detail</p>
                            <div class="color-7c7c7c mgB-5">
                                {!! $product->description !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail__related">
            <div class="text-center text-uper font-700 fs-25">related products</div>
            @include('product.main.partials.list-items')
        </div>

    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="/themes/v1/css/swiper.min.css">
@endpush

@push('scripts')
    <script type="text/javascript" src="/themes/v1/js/imagesloaded.pkgd.min.js"></script>
    <script type="text/javascript" src="/themes/v1/js/swiper.jquery.min.js"></script>
    <script type="text/javascript" src="/themes/v1/js/jquery.sticky-kit.min.js"></script>
    <script>
        var urlAddCart = "{{route('product.cart.add')}}";
        var sizeSelected = "{{$size}}";
    </script>
    <script type="text/javascript" src="{!! asset('js/front/product.js?v='.$version_deploy)  !!}"></script>
@endpush