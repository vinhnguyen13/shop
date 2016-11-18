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
        @if (!empty($products))
            @foreach($products as $product)
            <div class="col-lg-3 col-xs-6 col-md-4">
                <div class="product__item">
                    <div class="product__item--pic">
                        <a href=""><img data-original="{{$product->url()}}" alt="" class="lazy" /></a>
                    </div>
                    <div class="product__item--infor">
                        <div class="text-center mgB-40">
                            <div class="size-item">
                                <a href="" class="size">6</a>
                                <a href="" class="size">7</a>
                                <a href="" class="size">7.5</a>
                                <a href="" class="size">8</a>
                                <a href="" class="size">8.5</a>
                                <a href="" class="size">9</a>
                                <a href="" class="size">10</a>
                                <a href="" class="size">11</a>
                                <a href="" class="size">12</a>
                            </div>
                            <p class="text-uper">available size</p>
                        </div>
                        <div class="clearfix">
                            <p><a href="" class="product-name text-uper">{{$product->name}}</a></p>
                            <p class="fs-18 fontSFUBold pull-right">$ {{$product->price}}</p>
                            <p class="product-type text-uper">space gray</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        @endif
    </div>
    <div class="text-center">
        <a href="" class="btn-see-more text-uper">see more</a>
    </div>
</div>
<div class="container">
    <div class="row products">
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="/themes/v1/images/315x321.jpg" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        <div class="size-item">
                            <a href="" class="size">6</a>
                            <a href="" class="size">7</a>
                            <a href="" class="size">7.5</a>
                            <a href="" class="size">8</a>
                            <a href="" class="size">8.5</a>
                            <a href="" class="size">9</a>
                            <a href="" class="size">10</a>
                            <a href="" class="size">11</a>
                            <a href="" class="size">12</a>
                        </div>
                        <p class="text-uper">available size</p>
                    </div>
                    <div class="clearfix">
                        <p><a href="" class="product-name text-uper">nike kobe lontrau</a></p>
                        <p class="fs-18 fontSFUBold pull-right">? 3.800.000</p>
                        <p class="product-type text-uper">space gray</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="text-center">
        <a href="" class="btn-see-more text-uper">see more</a>
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