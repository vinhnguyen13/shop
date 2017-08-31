<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopProduct;
use App\Models\Backend\ShopSize;
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
        $product_id = Input::get('product_id');
        if(!empty($product_id)){
            $model = ShopProduct::find($product_id);
            if(!empty($model)) {
                $image = $model->getImages();
                $discounts = $model->getDiscount();
                $specials = $model->getSpecial();
                $details = $model->getDetails();
                $categoriesSelected = $model->getCategories();
                $sizes = $model->getSizes($categoriesSelected);
                return view('product.import', compact('model', 'image', 'discounts', 'specials', 'details', 'categoriesSelected', 'sizes'));
            }
        }
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
            $image = $model->getImages();
            $discounts = $model->getDiscount();
            $specials = $model->getSpecial();
            $details = $model->getDetails();
            $categoriesSelected = $model->getCategories();
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

    public function deleteReference(Request $request)
    {
        $type = $request->get('type');
        $id = $request->get('id');
        $return = app(ShopProduct::class)->deleteReference($type, $id);
        return ['return' => $return];
    }

    public function addProductDetail(Request $request)
    {
        $id = $request->get('id');
        $return = app(ShopProduct::class)->addMoreProductDetailWithSupplier($id);
        return ['code'=>0, 'message'=>'', 'return'=>$return];
    }

    public function productDetailGroup(Request $request)
    {
        $pid = $request->get('pid');
        $model = ShopProduct::find($pid);
        $html = '';
        if(!empty($model)) {
            $details = $model->getDetails();
            $suppliers = \App\Models\ShopSupplier::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
            foreach ($details as $key => $detail) {
                $html .= view('product._partials.form-detail-item', compact('key', 'detail', 'suppliers'))->render();
            }
        }
        return ['html' => $html];
    }

}