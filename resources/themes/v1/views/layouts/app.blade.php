<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('layouts.partials.ga')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="stylesheet" href="/themes/v1/css/bootstrap.min.css">
    <link rel="stylesheet" href="/themes/v1/css/reset.min.css">
    <link rel="stylesheet" href="/themes/v1/css/font.css">
    <link rel="stylesheet" href="/themes/v1/css/style.css">
    <link rel="stylesheet" href="/themes/v1/css/responsive.css">
    @stack('styles')
</head>
<body>
@include('layouts.partials.menu')
<div id="wrapper">
    @include('layouts.partials.header')
    <div id="container">
        @yield('content')
    </div>
    @include('layouts.partials.footer')
</div>
<script type="text/javascript" src="/themes/v1/js/jquery-1.11.1.js"></script>
<script type="text/javascript" src="/themes/v1/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/themes/v1/js/jquery.slimscroll.min.js"></script>
@stack('scripts')
<script type="text/javascript" src="/themes/v1/js/common.js"></script>
</body>
</html>
