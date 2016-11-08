<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopCustomer::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('customer.index', compact('grid'));
        }
    }

    public function create(Request $request)
    {
        $model = new ShopCustomer();
        return view('customer.form', compact('model', 'image'));
    }

    public function edit(Request $request, $id)
    {
        $model = ShopCustomer::find($id);
        if(!empty($model))
            return view('customer.form', compact('model'));
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
        $return = app(ShopCustomer::class)->updateOrCreate($attributes, $input);
        if(!empty($return->id)){
            return $this->index($request);
        }else{
            return Redirect::back();
        }
    }
}