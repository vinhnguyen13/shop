<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\Meta;
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
        $aliasUrl = \Route::getCurrentRoute()->getName();
        $metaHTML = app()->make(Meta::class)->addMeta($aliasUrl);
        \View::share([
            'metaHTML'=> $metaHTML,
            'categories'=> $categories,
            'manufacturers' => $manufacturers
        ]);
    }
}
