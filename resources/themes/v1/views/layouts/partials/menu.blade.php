<div id="menu">
    <div class="inner-menu">
        <button id="menu-close"><span></span></button>
        <ul>
            <li class="active"><a href="{{url('/')}}">home</a></li>
            <li><a href="">store</a></li>
            <li class="has-sub">
                <a href="">brands @if (!empty($categories))<span class="icon-chevron-thin-right"></span>@endif</a>
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
            <li><a href="">consigment</a></li>
            <li><a href="">location</a></li>
            <li><a href="">about us</a></li>
            <li><a href="">support</a></li>
        </ul>
        <div class="menu__footer">
            <div class="mgB-40">
                <a href=""><img src="/themes/v1/icons/logo-footer.png"></a>
            </div>
            <div class="center">
                <a class="fs-30 mgR-20" href=""><span class="icon-facebook"></span></a>
                <a href="" class="fs-30 mgR-20"><span class="icon-306026"></span></a>
                <a href="" class="fs-30"><span class="icon-play"></span></a>
            </div>
        </div>
    </div>
</div>