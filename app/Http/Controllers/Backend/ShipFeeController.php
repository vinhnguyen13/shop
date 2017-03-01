<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopShipFee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ShipFeeController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopShipFee::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('shipper.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopShipFee();
        return view('shipper.form', compact('model'));
    }

    public function show(Request $request, $id)
    {
        $model = ShopShipFee::find($id);
        return view('shipper.view', compact('model'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopShipFee::find($id);
        if(!empty($model))
            return view('shipper.form', compact('model'));
        else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopShipFee::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.shipper.index');
        }else{
            return Redirect::back();
        }
    }

    public function delete(Request $request, $id)
    {
        $model = ShopShipFee::find($id);
        if(!empty($model)) {
            $model->delete();
        }
        return Redirect::route('admin.shipper.index');
    }

}