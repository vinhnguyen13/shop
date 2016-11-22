@if (!empty($products) && $products->count())
    <div class="row products">
    @foreach($products as $product)
        <?php
        $url = route('product.detail', ['id'=>$product->id, 'slug'=>str_slug($product->name)]);
        $sizes = $product->sizes;
        ?>
        <div class="col-lg-3 col-xs-6 col-md-4">
            <div class="product__item">
                <div class="product__item--pic">
                    <a href="{{$url}}"><img data-original="{{$product->url()}}" alt="" class="lazy" /></a>
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
                        <p class="fs-18 fontSFUBold pull-right">vnđ {{number_format($product->price, 0)}}</p>
                        <p class="product-type text-uper">{{$product->color}}</p>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    </div>
    <div class="text-center">
        <a href="{{route('product.index')}}" class="btn-see-more text-uper">see more</a>
    </div>
@else
    <div class="row products">
        No products
    </div>
@endif