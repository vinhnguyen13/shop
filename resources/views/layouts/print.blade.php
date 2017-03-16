<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, height=device-height, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
    <title>{{ config('app.name', 'Glab') }}</title>
    <link rel="stylesheet" href="{{asset('/themes/v1/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('/themes/v1/css/reset.min.css')}}">
    <link rel="stylesheet" href="{{asset('/themes/v1/css/font.css')}}">
    <link rel="stylesheet" href="{{asset('/themes/v1/css/style.css')}}">
    <link rel="stylesheet" href="{{asset('/themes/v1/css/responsive.css')}}">
</head>
<body>
@yield('content')
</body>
</html>
