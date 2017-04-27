<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopSupplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopSupplier::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('supplier.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopSupplier();
        return view('supplier.form', compact('model', 'image'));
    }

    public function show(Request $request, $id)
    {
        $model = ShopSupplier::find($id);
        return view('supplier.view', compact('model'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopSupplier::find($id);
        if(!empty($model))
            return view('supplier.form', compact('model'));
        else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopSupplier::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.supplier.index');
        }else{
            return Redirect::back();
        }
    }

    public function delete(Request $request, $id)
    {
        $model = ShopSupplier::find($id);
        if(!empty($model)) {
            $model->delete();
        }
        return Redirect::route('admin.supplier.index');
    }


    public function get(Request $request)
    {
        $id = Input::get('id');
        $model = ShopSupplier::find($id);
        if(!empty($model)) {
            return $model->getAttributes();
        }
    }

}