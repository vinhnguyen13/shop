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

if (! function_exists('categoryMultiLevel')) {
    function categoryMultiLevel(array $objects, $parent=0, $depth=0, array &$result=array()) {
        foreach ($objects as $key => $object) {
            if ($object->parent_id == $parent) {
                $object->depth = $depth;
                array_push($result, $object);
                unset($objects[$key]);
                categoryMultiLevel($objects, $object->id, $depth + 1, $result);
            }
        }
        return $result;
    }
}