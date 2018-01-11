<?php
if (! function_exists('test')) {
    function test()
    {
        return rand(0, 100);
    }
}

if (! function_exists('menu_active')) {
    function menu_active($routes)
    {
        $currentRouteName = Route::getCurrentRoute()->getName();
        if(in_array($currentRouteName, $routes)){
            return 'active';
        }
        return '';
    }
}

if (! function_exists('input')) {
    function input($item)
    {
        $input = Input::all();
        if(!empty($input[$item])){
            return $input[$item];
        }
    }
}

if (! function_exists('url_exists')) {
    function url_exists($url) {
        $headers = @get_headers($url);
        if(strpos($headers[0],'200')===false)return false;
        return true;
    }
}