<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopCategory;
use App\Models\Backend\ShopManufacturer;
use App\Models\Backend\ShopSize;
use App\Models\Backend\ShopSizeCategory;
use App\Models\Backend\ShopSizeLocales;
use App\Models\Backend\ShopSizePerson;
use Illuminate\Http\Request;
use Input;
use Illuminate\Support\Facades\Redirect;

class SizeController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopSize::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('product-size.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopSize();
        $categories = ShopCategory::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
        $sizePersons = ShopSizePerson::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
        $manufacturers = ShopManufacturer::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
        $locales = ShopSizeLocales::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
        $sizeCategories = ShopSizeCategory::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
        $sku_producer = $request->get('sku_producer');
        $model->sku_producer = $sku_producer;
        return view('product-size.form', compact('model', 'categories', 'sizePersons', 'manufacturers', 'locales', 'sizeCategories'));
    }

    public function show(Request $request, $id)
    {
        $model = ShopSize::find($id);
        return view('product-size.view', compact('model'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopSize::find($id);
        if(!empty($model)) {
            $categories = ShopCategory::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
            $sizePersons = ShopSizePerson::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
            $manufacturers = ShopManufacturer::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
            $locales = ShopSizeLocales::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
            $sizeCategories = ShopSizeCategory::query()->orderBy('id')->pluck('name', 'id')->prepend('- Please Select -', 0);
            return view('product-size.form', compact('model', 'categories', 'sizePersons', 'manufacturers', 'locales', 'sizeCategories'));
        }else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopSize::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.productSize.index');
        }else{
            return Redirect::back()->withErrors($return);
        }
    }

    public function delete(Request $request, $id)
    {
        $model = ShopSize::find($id);
        if(!empty($model)) {
            $model->processingDelete();
        }
        return Redirect::route('admin.product.index');
    }


}