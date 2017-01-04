@extends('layouts.app')

@section('content')
    <div class="container detail wrap-checkout">
        <div class="checkout__inner">
            @if(!empty($cart))
                <div class="clearfix mgB-20">
                    <p class="pull-right">Date: {{date('D F, Y')}}</p>
                    <p class="fontSFUBold fs-15">Glab.VN</p>
                    <p>135/58 Trần Hưng Đạo, Quận 1, <br> Ho Chi Minh City, Vietnam </p>
                    <p>ĐT: 094 537 88 09</p>
                </div>


                <div class="row mgB-20 mgT-5">
                    <div class="col-md-7">
                        <form method="post" action="" class="form-horizontal" id="orderForm">
                            {{ csrf_field() }}
                            @include('product.partials.cart-products')
                            @include('product.partials.cart-shipping')
                            @include('product.partials.cart-billing')
                            @include('product.partials.cart-payment')
                            <div class="form-group">
                                <div class="col-md-12 text-right">
                                    <button type="button" class="btn btn-primary btn-lg btn-checkout btn-back hide">Trở lại</button>
                                    <button type="submit" class="btn btn-primary btn-lg btn-checkout btn-order">Đặt hàng</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-md-5">
                        <div class="checkout__infor">
                            <p class="font-bold mgB-10">Địa chỉ giao hàng/Thanh toán</p>
                            <p>Trương Hoàng Điển</p>
                            <p>21 Nguyễn Trung Ngạn</p>
                            <p>Hồ Chí Minh-Quận 1</p>
                            <p>Điện thoại di động: 0905296128</p>
                            <p class="mgT-20 font-bold mgB-10">Thông tin đơn hàng</p>
                            <table class="table fs-12">
                                <tbody><tr>
                                    <th class="w-45">SẢN PHẨM</th>
                                    <th>SỐ LƯỢNG</th>
                                    <th>GIÁ</th>
                                </tr>
                                <tr>
                                    <td>Apple iPhone 7 32GB (Vàng Hồng) - Hàng nhập khẩu</td>
                                    <td>
                                        <select name="" id="" class="w-100">
                                            <option value="">1</option>
                                            <option value="">2</option>
                                        </select>
                                        <p class="text-center mgT-5"><a href="" class="text-decor fs-12">xóa</a></p>
                                    </td>
                                    <td>15.490.000</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-bold">Tạm tính</td>
                                    <td>15.490.000 VND</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-bold">Phí vận chuyển</td>
                                    <td>Miễn phí</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="font-bold">
                                        Thành tiền
                                        <p>(Tổng số tiền thanh toán)</p>
                                    </td>
                                    <td class="text-danger font-bold fs-13">15.490.000 VND</td>
                                </tr>
                                </tbody></table>
                        </div>
                    </div>
                </div>
            @else
                <div class="alert alert-info fade in alert-dismissable">
                    <h4><i class="icon fa fa-warning"></i> Thông báo!</h4>
                    Không có sản phẩm nào trong giỏ hàng.
                </div>
                <a href="{{url('/')}}" class="btn btn-block btn-success">Tiếp tục mua hàng</a>
            @endif
        </div>
    </div>

@endsection

@push('styles')
    <link href="{!! asset('css/front/checkout.css') !!}" rel="stylesheet">
@endpush

@push('scripts')
    <script>
        var urlRemoveCart = "{{route('product.cart.remove')}}";
        var urlOrder = "{{route('product.order')}}";
    </script>
    <script src="{!! asset('js/front/checkout.js')  !!}"></script>
@endpush