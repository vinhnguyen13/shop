<header class="clearfix">
    <div class="container">
        <div class="pull-left lh-50 header__left">
            <button id="menu-open" class=""><span></span></button>
            <div class="auth__user">
                <a href="" class="toggle__auth"><span class="icon-slice6"></span></a>
                @if (Auth::guard('web')->guest())
                    <ul>
                        <li><a href="{{route('login')}}">LOG IN</a></li>
                        <li><a href="{{route('register')}}">CREATE ACCOUNT</a></li>
                    </ul>
                @else
                    <ul>
                        <li><a href="javascript:;">{{auth()->user()->name}}</a></li>
                        <li><a href="{{route('logout')}}">LOGOUT</a></li>
                    </ul>
                @endif
            </div>
        </div>
        <div class="pull-right lh-50 header__right">
            <form class="search" id="search">
                <a href="" class="header__right--mbsearch"><span class="icon-search"></span></a>
                <div class="frm-icon">
                    <input type="text" placeholder="Search" />
                    <button type="submit" class="icon-frm"><span class="icon-slice9"></span></button>
                </div>
            </form>
            <div class="header__cart dropdown">
                <a href="" class="val-selected"><span class="icon-slice8"></span><span class="header__cart--num {!! (!empty($cart)) ? '' :'hide' !!}">({!! count($cart)!!})</span></a>
                <div class="dropdown-up-style hide">
                    <div class="dropdown__inner">
                        @include('product.main.partials.cart-header')
                    </div>
                </div>
            </div>
        </div>
        <div class="text-center lh-50 header__logo">
            <span>logo</span>
            <a href="{{url('/')}}"><img src="/themes/v1/icons/logo.svg" alt=""/></a>
        </div>
    </div>
</header>