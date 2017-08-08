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
use Input;
use Illuminate\Support\Facades\Redirect;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopProduct::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('size.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopProduct();
        $sku_producer = $request->get('sku_producer');
        $model->sku_producer = $sku_producer;
        return view('size.form', compact('model', 'sku_producer'));
    }

    public function show(Request $request, $id)
    {
        $model = ShopProduct::find($id);
        return view('size.view', compact('model'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopProduct::find($id);
        if(!empty($model)) {
            $image = $model->getImagesToForm();
            $discounts = $model->getDiscountToForm();
            $specials = $model->getSpecialToForm();
            $details = $model->getDetailsToForm();
            $categoriesSelected = $model->getCategoriesToForm();
            return view('size.form', compact('model', 'image', 'discounts', 'specials', 'details', 'categoriesSelected'));
        }else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopProduct::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.product.index');
            return Redirect::route('admin.product.edit', ['id'=>$return->id]);
        }else{
            return Redirect::back()->withErrors($return);
        }
    }

    public function delete(Request $request, $id)
    {
        $model = ShopProduct::find($id);
        if(!empty($model)) {
            $model->processingDelete();
        }
        return Redirect::route('admin.product.index');
    }


}