@extends('layouts.app')

@section('content')
<div class="text-center mgT-50">
    <ul class="breakcum">
        <li><a href="">home</a></li>
        <li><span>/</span></li>
        <li class="active"><a href="">about us</a></li>
    </ul>
</div>
<div class="aboutus">
    <div class="aboutus__inner">
        <p class="font-600 fs-36 mgB-20 ">ABOUT G-LAB</p>
        <p class="font-600 fs-18 mgB-20">On September 9th 2014 by sneaker-head dedicating our time and sweat to inspire the young by the activeness and the creativity of sneaker culture.</p>
        <p class="font-600 fs-18 mgB-20">Not only a sneakers store. We create an energized place for customers shopping, experience and sharing.</p>
        <p class="font-600 fs-18 mgB-20">Không đơn thuần là một cửa hàng, G-LAB còn là một không gian văn hoá để những người yêu giày có thể đến để giao lưu, chia sẻ đam mê cũng như tìm kiếm những trải nghiệm riêng của bản thân mình. G-LAB được sinh ra ra với tiêu chí đem đến những sản phẩm chất lượng cùng những nét đẹp của nền văn hóa giày đặc sắc.</p>
    </div>
    <div class="wrap-img">
        <img src="/themes/v1/images/d-s-c-01558.jpg" alt="">
    </div>
    <div class="aboutus__inner">
        <p class="font-600 fs-36 mgB-20 ">LOCATION</p>
        <p class="font-600 fs-18 mgB-20">135/58 Trần Hưng Đạo, Quận 1. Ho Chi Minh City, Vietnam</p>
        <p class="font-600 fs-18 mgB-50"><a href="tel:0945378809">Call 094 537 88 09</a></p>
        <p class="font-600 fs-36 mgB-20  text-uper">connect us</p>
        <div>
            <a href="" class="mgR-40 fs-30"><span class="icon-facebook2"></span></a>
            <a href="" class="mgR-50 fs-30"><span class="icon-306026"></span></a>
            <a href="" class="fs-30"><span class="icon-play"></span></a>
        </div>
    </div>
</div>
@endsection