@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout filter__shop">
        <div class="text-center mgB-50">
            <ul class="breakcum">
                <li><a href="">HOME</a></li>
                <li><span>/</span></li>
                <li class="active">STAFF AREA</li>
            </ul>
        </div>
        <div class="checkout__inner clearfix">
            <form class="frm-filter">
                <div class="checkout__infor" style="width:100%;">
                    <div class="filter__product">
                        <div class="frm-item">
                            <div class="frm-item-icon searchProduct" data-url-products="{{route('api.product.search')}}" data-url-product="{{route('api.product.get')}}">
                                <input type="text" placeholder="Name , SKU , Color ..." name="word">
                                <button><span class="icon-slice9"></span></button>
                            </div>
                        </div>

                        <div class="filter__item">
                            <table>
                                <tr>
                                    <td>
                                        <div class="dropdown">
                                            <a href="" class="val-selected">
                                                Brand
                                                <div class="get-val"></div>
                                                <span class="icon-uniF140"></span>
                                            </a>
                                            <div class="dropdown-up-style hide">
                                                <div class="dropdown__inner">
                                                    @if (!empty($manufacturers))
                                                    <ul>
                                                        <li><a href="" data-value="0">- None -</a></li>
                                                        @foreach($manufacturers as $manufacturer)
                                                        <li><a href="" data-value="{{$manufacturer->id}}">{{$manufacturer->name}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="hidden" value="" name="manufacturer" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="" class="val-selected">
                                                Size
                                                <div class="get-val"></div>
                                                <span class="icon-uniF140"></span>
                                            </a>
                                            <div class="dropdown-up-style hide">
                                                <div class="dropdown__inner">
                                                    @if (!empty($sizes))
                                                    <ul>
                                                        {{--<li><label for="" class="frm"><input type="radio" />Men US</label></li>--}}
                                                        {{--<li><label for="" class="frm"><input type="radio" />Women US</label></li>--}}
                                                        @foreach($sizes as $size)
                                                            <li><a href="" data-value="{{$size}}">{{$size}}</a></li>
                                                        @endforeach
                                                    </ul>
                                                    @endif
                                                </div>
                                            </div>
                                            <input type="hidden" value="" name="size" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <a href="" class="val-selected">
                                                Color
                                                <div class="get-val"></div>
                                                <span class="icon-uniF140"></span>
                                            </a>
                                            <div class="dropdown-up-style hide">
                                                <div class="dropdown__inner">
                                                    <ul>
                                                        <li><a href="" data-value="1">red</a></li>
                                                        <li><a href="" data-value="2">black</a></li>
                                                        <li><a href="" data-value="3">bla bla</a></li>
                                                        <li><a href="" data-value="4">bla bla</a></li>
                                                        <li><a href="" data-value="5">bla bla</a></li>
                                                        <li><a href="" data-value="6">bla bla</a></li>
                                                        <li><a href="" data-value="7">bla bla</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <input type="hidden" value="" name="color" />
                                        </div>
                                    </td>
                                    <td>
                                        <div class="clearfix price__range">
                                            <div class="pull-left">
                                                <p class="font-600">From</p>
                                            </div>
                                            <div class="pull-right">
                                                <input type="text" value="" class="filter__price" name="from_price" />đ
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="clearfix price__range">
                                            <div class="pull-left">
                                                <p class="font-600">To</p>
                                            </div>
                                            <div class="pull-right pdR-10">
                                                <input type="text" value="" class="filter__price" name="to_price" />đ
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div class="filter__item--btn text-center">
                                <button class="btn-small btn-apply">APPLY</button>
                                <button class="btn-reset">RESET</button>
                            </div>
                        </div>

                        <div class="filter__result">
                            <div class="alert alert-info fade in alert-dismissable">
                                <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
                                Bạn vui lòng nhập điều kiện để lọc sản phẩm cần tìm
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('styles')
<link href="{!! asset('https://code.jquery.com/ui/1.11.1/themes/smoothness/jquery-ui.css') !!}" rel="stylesheet">
<style>
    input[type='text'].ui-autocomplete-loading {
        background:  url('http://www.hsi.com.hk/HSI-Net/pages/images/en/share/ajax-loader.gif') no-repeat right center;
    }
</style>
@endpush

@push('scripts')
<script src="{!! asset('http://code.jquery.com/ui/1.11.1/jquery-ui.min.js?v='.$version_deploy)  !!}"></script>
<script type="text/javascript">
    var urlAddCart = "{{route('product.cart.add')}}";
    var urlCheckoutForStaff = "{{route('product.checkout.forStaff')}}";
</script>
<script type="text/javascript" src="{!! asset('js/front/checkout-for-staff.js?v='.$version_deploy)  !!}"></script>
@endpush