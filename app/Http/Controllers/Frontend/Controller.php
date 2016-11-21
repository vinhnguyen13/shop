<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use DB;
use Cache;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $minutes = 10;
        $categories = Cache::remember('categories', $minutes, function() {
            return DB::table('shop_category')->get();
        });
        $manufacturers = Cache::remember('manufacturers', $minutes, function() {
            return DB::table('shop_manufacturer')->get();
        });
        \View::share('categories', $categories);
        \View::share('manufacturers', $manufacturers);
    }
}
