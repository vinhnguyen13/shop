<header class="clearfix">
    <div class="container">
        <div class="pull-left lh-50 header__left">
            <button id="menu-open" class=""><span></span></button>
            <div class="dropdown">
                <a href="" class="val-selected"><span class="icon-697822"></span></a>
                <div class="dropdown-up-style hide">
                    <div class="dropdown__inner">
                        <ul>
                            @if (Auth::guard('web')->guest())
                                <li><a href="{{route('login')}}"><span class="icon-login"></span>Đăng nhập</a></li>
                                <li><a href="{{route('register')}}"><span class="icon-add-user"></span>Đăng ký</a></li>
                                {{--<li class="btn-auth-go"><a href="{{route('auth.getSocialAuth', ['provider'=>\App\Models\SocialAccount::PROVIDER_FACEBOOK])}}"><span class="icon-google-plus"></span>Google</a></li>--}}
                                {{--<li class="btn-auth-face"><a href="{{route('auth.getSocialAuth', ['provider'=>\App\Models\SocialAccount::PROVIDER_FACEBOOK])}}"><span class="icon-facebook"></span>Facebook</a></li>--}}
                            @else
                                <li> <a href="javascript:;">{{auth()->user()->name}}</a></li>
                                <li> <a href="{{route('logout')}}">Đăng xuất</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="pull-right lh-50 header__right">
            <form id="search">
                <a href="" class="header__right--mbsearch"><span class="icon-search"></span></a>

                <div class="frm-icon">
                    <input type="text" placeholder="Search"/>
                    <button type="submit" class="icon-frm"><span class="icon-search"></span></button>
                </div>
            </form>
            <div class="header__cart dropdown">
                <a href="" class="val-selected"><span class="icon-cart"></span><span class="header__cart--num">{{count($cart)}}</span></a>

                <div class="dropdown-up-style hide">
                    <div class="dropdown__inner">
                        <h2 class="text-uper fontSFUBold fs-16">your cart</h2>

                        @if(!empty($cart))
                            <div class="header__cart--items">
                                    <?php
                                    $subtotal = 0;
                                    $tax = 0;
                                    $total = 0;
                                    ?>
                                    @foreach($cart as $item)
                                        <?php
                                        $product = App\Models\Frontend\ShopProduct::find($item['product_id']);
                                        $product->setCart($item['size'], $item['quantity']);
                                        $price = $product->priceWithSize();
                                        $subtotalProduct = $price * $item['quantity'];
                                        $subtotal += $subtotalProduct;
                                        $tax += $product->taxWithPrice($price);
                                        ?>
                                <a href="" class="header__cart--item clearfix">
                                    <div class="pull-left wrap-img">
                                        <img src="/themes/v1/images/310x177.jpg" alt="">
                                    </div>
                                    <div class="overflow-all">
                                        <p class="text-uper fs-15 fontSFUBold">{{$product->name}}</p>

                                        <p class="product-type text-uper fontSFURe fs-13 mgB-10">{{$product->color}}</p>

                                        <p class="pull-right fontSFUBold fs-15">đ {{number_format($subtotalProduct)}}</p>

                                        <p class="text-uper fontSFUBold fs-14">Size: {{$product->size()}} - Quantity: {{$item['quantity']}}</p>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                            <div class="clearfix mgB-20">
                                <span class="text-uper fs-14 fontSFUMeBold">subtotal</span>

                                <p class="pull-right product-price">đ {{number_format($subtotal)}}</p>
                            </div>
                            <div class="text-center">
                                <p class="fontSFURe fs-15 mgB-15">Shipping &amp; taxes calculated at checkout</p>
                                <a href="{{route('product.checkout')}}" class="text-uper btn-checkout fontSFUL">check out</a>
                            </div>
                        @else
                            <div class="text-center">
                                <p class="fontSFURe fs-15 mgB-15">Không có sản phẩm nào !</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center lh-50 header__logo">
            <span>logo</span>
            <a href="{{url('/')}}"><img src="/themes/v1/icons/logo-header.png" alt=""/></a>
        </div>
    </div>
</header>