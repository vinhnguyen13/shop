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
        $sku_producer = $request->get('sku_producer');
        $model->sku_producer = $sku_producer;
        return view('product.form', compact('model', 'sku_producer'));
    }

    public function import(Request $request)
    {
        $model = new ShopProduct();
        if($request->isMethod('post')) {
            $sku_producer = Input::get('sku_producer');
            if(!empty($sku_producer)){
                $sku_producer = trim($sku_producer);
                $model = ShopProduct::where(['sku_producer'=>$sku_producer])->first();
                if(!empty($model)){
                    return redirect(route('admin.product.edit', ['id'=>$model->id]));
                }else{
                    return redirect(route('admin.product.create', ['sku_producer'=>$sku_producer]));
                }
            }
        }
        return view('product.import', compact('model', 'image'));
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
            $details = $model->getDetailsToForm();
            $categoriesSelected = $model->getCategoriesToForm();
            return view('product.form', compact('model', 'image', 'discounts', 'specials', 'details', 'categoriesSelected'));
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

    public function addProductDetail(Request $request)
    {
        $type = $request->get('type');
        $id = $request->get('id');
//        $return = app(ShopProduct::class)->deleteReference($type, $id);
//        return ['return' => $return];
    }

}