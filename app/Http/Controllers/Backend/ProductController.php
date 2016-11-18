<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopProduct;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopProduct::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('product.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopProduct();
        return view('product.form', compact('model', 'image'));
    }

    public function show(Request $request, $id)
    {
        $model = ShopProduct::find($id);
        return view('product.view', compact('model'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopProduct::find($id);
        if(!empty($model)) {
            $image = $model->getImagesToForm();
            $discounts = $model->getDiscountToForm();
            $specials = $model->getSpecialToForm();
            $sizes = $model->getSizeToForm();
            $categoriesSelected = $model->getCategoriesToForm();
            return view('product.form', compact('model', 'image', 'discounts', 'specials', 'sizes', 'categoriesSelected'));
        }else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopProduct::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.product.index');
        }else{
            return Redirect::back()->withErrors($return);
        }
    }

    public function delete(Request $request, $id)
    {
        $model = ShopProduct::find($id);
        if(!empty($model)) {
            $model->delete();
        }
        return Redirect::route('admin.product.index');
    }

    public function deleteReference(Request $request)
    {
        $type = $request->get('type');
        $id = $request->get('id');
        $return = app(ShopProduct::class)->deleteReference($type, $id);
        return ['return' => $return];
    }

}