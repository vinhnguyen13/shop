<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ShopShipper;
use Illuminate\Http\Request;

class ShipperController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopShipper::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('shipper.index', compact('grid'));
        }
    }

    public function transport()
    {
        return view('home.index', ['content'=> PHP_EOL.\Illuminate\Foundation\Inspiring::quote().PHP_EOL]);
    }

}