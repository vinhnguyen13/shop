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
use Illuminate\Support\Facades\Input;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopCategory::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('category.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopCategory();
        return view('category.form', compact('model', 'image'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopCategory::find($id);
        if(!empty($model))
            return view('category.form', compact('model'));
        else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopCategory::class)->updateData($input);
        if(!empty($return->id)){
            return Redirect::route('user.index');
        }else{
            return Redirect::back();
        }
    }

}