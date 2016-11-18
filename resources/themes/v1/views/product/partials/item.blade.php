@if (!empty($products))
    @foreach($products as $product)
        @php
        $sizes = $product->sizes;
        @endphp
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href=""><img data-original="{{$product->url()}}" alt="" class="lazy" /></a>
                </div>
                <div class="product__item--infor">
                    <div class="text-center mgB-40">
                        @if (!empty($sizes) && count($sizes) > 0)
                            <div class="size-item">
                                @foreach($sizes as $size)
                                    <a href="" class="size">{{$size->size}}</a>
                                @endforeach
                            </div>
                            <p class="text-uper">available size</p>
                        @else
                            <div class="size-item">&nbsp;</div>
                            <p class="text-uper">out of stock</p>
                        @endif
                    </div>
                    <div class="clearfix">
                        <p><a href="{{$product->id}}" class="product-name text-uper">{{$product->name}}</a></p>
                        <p class="fs-18 fontSFUBold pull-right">$ {{number_format($product->price, 0)}}</p>
                        <p class="product-type text-uper">{{$product->color}}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endif