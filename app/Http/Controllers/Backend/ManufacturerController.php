<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Backend\ShopManufacturer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class ManufacturerController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopManufacturer::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('manufacturer.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopManufacturer();
        return view('manufacturer.form', compact('model', 'image'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopManufacturer::find($id);
        if(!empty($model))
            return view('manufacturer.form', compact('model'));
        else
            return abort(404, 'Not Found');
    }

    public function store(Request $request)
    {
        $input = Input::all();
        unset($input['_token']);
        if(!empty($input['id'])){
            $attributes = ['id'=>$input['id']];
        }else{
            $attributes = ['id'=>$input['id']];
        }
        $return = app(ShopManufacturer::class)->updateOrCreate($attributes, $input);
        if(!empty($return->id)){
            return $this->index($request);
        }else{
            return Redirect::back();
        }
    }
}