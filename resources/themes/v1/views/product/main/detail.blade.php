@extends('layouts.app')

@section('content')
    <?php
    $images = $product->images;
    $details = $product->getDetailsGroupBySize();
    $quantities = [1,2,3,4,5];
    ?>
    <div class="container detail">
        <div class="row">
            <div class="detail__img col-sm-8">
                <div class="slidedetailpage">
                    @if (!empty($images) && count($images) > 0)
                        @foreach($images as $image)
                            <div class="slidedetail__item">
                                <img src="{{$image->url('original')}}" alt="" />
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="slidedetail__pagi"></div>
            </div>
            <div class="col-sm-4 detail__desc">
                <div class="detail__desc--inner">
                    <div class="detail__desc--fix">
                        <ul class="breakgum clearfix">
                            <li><a href="{{url('/')}}">home</a></li>
                            <li><span>/</span></li>
                            <li><a href="{{route('product.category', ['category'=>'footwear'])}}">footwear</a></li>
                            <li><span>/</span></li>
                            <li>{{$product->name}}</li>
                        </ul>
                        <p class="text-uper fontSFUL lh-30 fs-40 mgB-10">{{$product->manufacturer->name or ''}}</p>
                        <p class="text-uper fontSFUMeBold fs-40 mgB-0 lh-40 mgB-20">{{$product->name}}</p>
                        @if (!empty($details) && $details->count() > 0)
                        <div class="mgB-20">
                            <div class="dropdown">
                                <form id="frmAddCart" method="POST">
                                    <a href="" class="val-selected clearfix"><span class="icon-chevron-thin-down"></span><div class="get-val">choose your size</div></a>
                                    <div class="dropdown-up-style hide">
                                        <div class="dropdown__inner">
                                            <ul>
                                                @foreach($details as $detail)
                                                    @if (!empty($detail->size))
                                                        <li><a href=""><span class="pull-right detail__price" data-value="{{$detail->getPrice()}}">{{number_format($detail->getPrice())}} đ</span><span class="detail__size" data-value="{{encrypt($detail->id)}}">{{$detail->size}}</span></a></li>
                                                    @endif
                                                @endforeach
                                            </ul>
                                            <input type="hidden" name="detail" id="val-size" value="">
                                            <input type="hidden" name="price" id="val-price" value="">
                                            <input type="hidden" name="quantity" value="1">
                                        </div>
                                    </div>
                                </form>
                            </div>
                            <button type="submit" class="btn-buy text-uper">add to cart</button>
                        </div>
                        @endif
                        <div class="detail__desc--intro">
                            <p class="title__detailproduct">Detail</p>
                            <p>{!! $product->description !!}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="detail__related">
            <div class="text-center text-uper fontSFUBold fs-25">related products</div>
            @include('product.main.partials.list-items')
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
    </script>
    <script type="text/javascript" src="{!! asset('js/front/product.js')  !!}"></script>
@endpush