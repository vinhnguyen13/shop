<div id="menu">
    <button id="menu-close"><span></span></button>
    <div class="menu__footer">
        <div class="mgB-10 fs-14 fontSFUBold">FOLLOW US</div>
        <div class="center clearfix">
            <a href=""><span class="icon-facebook2"></span></a>
            <a href=""><span class="icon-306026"></span></a>
            <a href=""><span class="icon-play"></span></a>
        </div>
    </div>
    <div class="inner-menu">
        <div>
            <ul>
                <li class="logo-white"><a href=""><img src="/themes/v1/icons/g-lab-logo-white.svg" /></a></li>
                <li class="active"><a href="{{url('/')}}"><span class="menu__txt">home</span></a></li>
                <li class="has-sub">
                    <a href=""><span class="menu__txt">store</span> @if (!empty($categories))<span class="icon-chevron-thin-right"></span>@endif</a>
                    @if (!empty($categories))
                    <div class="menu__sub">
                        <ul>
                            @foreach($categories as $category)
                            <li><a href="{{route('product.category', ['category'=>str_slug($category->slug)])}}">{{$category->name}}</a></li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </li>
                <li class="has-sub">
                    <a href=""><span class="menu__txt">brands</span> @if (!empty($manufacturers))<span class="icon-chevron-thin-right"></span>@endif</a>
                    @if (!empty($manufacturers))
                        <div class="menu__sub">
                            <ul>
                                @foreach($manufacturers as $manufacturer)
                                    <li><a href="{{route('product.brand', ['brand'=>str_slug($manufacturer->slug)])}}">{{$manufacturer->name}}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                </li>
                <li><a href=""><span class="menu__txt">consigment</span></a></li>
                <li><a href=""><span class="menu__txt">location</span></a></li>
                <li><a href=""><span class="menu__txt">about us</span></a></li>
                <li><a href=""><span class="menu__txt">support</span></a></li>
            </ul>
        </div>
    </div>
</div>