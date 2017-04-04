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