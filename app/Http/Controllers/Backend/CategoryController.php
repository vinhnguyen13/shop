<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ShopCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopCategory::class)->grid();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('category.index', compact('grid'));
        }
    }

}