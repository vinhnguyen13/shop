@foreach($products as $product)
    <?php
    $url = route('product.detail', ['id'=>$product->id, 'slug'=>str_slug($product->name)]);
    $details = $product->getDetailsGroupBySupplier();
    ?>
    <div class="col-lg-3 col-xs-6 col-md-4">
        <div class="product__item">
            <div class="product__item--pic">
                <a href="{{$url}}">
                    <div class="product__img">
                        <img data-original="{{$product->thumb()}}" alt="" class="lazy" />
                    </div>
                </a>
                <div class="product__item--infor">
                    <div class="text-center mgB-20">
                        @if (!empty($details) && count($details) > 0)
                            <div class="size-item">
                                @foreach($details as $detail)
                                    <a href="" class="size">{{$detail->size}}</a>
                                @endforeach
                            </div>
                            <p class="text-uper">available size</p>
                        @else
                            <div class="size-item">&nbsp;</div>
                            <p class="text-uper">out of stock</p>
                        @endif
                    </div>
                    <div class="clearfix">
                        <p class="fs-18 fontSFUBold pull-right">{{number_format($product->price, 0)}}</p>
                        <p class="product-name text-uper">{{$product->name}}</p>
                        <p class="product-type text-uper">{{$product->color}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endforeach