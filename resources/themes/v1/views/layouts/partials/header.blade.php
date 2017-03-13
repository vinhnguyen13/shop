<header class="clearfix">
    <div class="container">
        <div class="pull-left lh-50 header__left">
            <button id="menu-open" class=""><span></span></button>
            <div class="auth__desktop">
                @if (Auth::guard('web')->guest())
                    <a href="{{route('login')}}" class="fontSFUMeBold fs-15">LOG IN</a>
                    <a href="{{route('register')}}" class="fontSFUMeBold fs-15">CREATE ACCOUNT</a>
                @else
                    <a href="javascript:;">{{auth()->user()->name}}</a>
                    <a href="{{route('logout')}}">Đăng xuất</a>
                @endif
            </div>
            <div class="dropdown">
                <a href="" class="val-selected"><span class="icon-slice6"></span></a>
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