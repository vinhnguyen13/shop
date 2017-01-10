<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    @include('layouts.partials.ga')
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    {!! $metaHTML or '' !!}
    <link rel="stylesheet" href="{{ asset('/themes/v1/css/bootstrap.min.css?v='.$version_deploy) }}">
    <link rel="stylesheet" href="{{ asset('/themes/v1/css/reset.min.css?v='.$version_deploy) }}">
    <link rel="stylesheet" href="{{ asset('/themes/v1/css/font.css?v='.$version_deploy) }}">
    <link rel="stylesheet" href="{{ asset('/themes/v1/css/style.css?v='.$version_deploy) }}">
    <link rel="stylesheet" href="{{ asset('/themes/v1/css/common.css?v='.$version_deploy) }}">
    @stack('styles')
    <link rel="stylesheet" href="{{ asset('/themes/v1/css/responsive.css?v='.$version_deploy) }}">
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
<script type="text/javascript" src="{{ asset('/themes/v1/js/jquery-1.11.1.js?v='.$version_deploy) }}"></script>
<script type="text/javascript" src="{{ asset('/themes/v1/js/bootstrap.min.js?v='.$version_deploy) }}"></script>
<script type="text/javascript" src="{{ asset('/themes/v1/js/jquery.slimscroll.min.js?v='.$version_deploy) }}"></script>
<script type="text/javascript" src="{{ asset('/themes/v1/js/common.js?v='.$version_deploy) }}"></script>
<script type="text/javascript" src="{{ asset('/themes/v1/js/common-dev.js?v='.$version_deploy) }}"></script>
@stack('scripts')
</body>
</html>
