<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopShipper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

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

    public function create(Request $request)
    {
        $model = new ShopShipper();
        return view('shipper.form', compact('model', 'image'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopShipper::find($id);
        if(!empty($model))
            return view('shipper.form', compact('model'));
        else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        $return = app(ShopShipper::class)->updateOrCreate(['id'=>$input['id']], $input);
        if(!empty($return->id)){
            return Redirect::route('admin.shipper.index');
        }else{
            return Redirect::back();
        }
    }

}