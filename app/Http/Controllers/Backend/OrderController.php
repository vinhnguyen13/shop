<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopOrder;
use App\Models\Backend\User;
use Illuminate\Http\Request;
use Input;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $input = Input::all();
        $grid = app(ShopOrder::class)->gridIndex($input);
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('order.index', compact('grid'));
        }
    }

    public function getStatusForUpdate(Request $request)
    {
        $crStatus = Input::get('status');
        if ($request->ajax()) {
            return \Form::select('status', \App\Models\ShopOrderStatus::getStatusWithCurrentStatus($crStatus), null, ['class'=>'form-control']);
        }
    }

    public function updateStatus(Request $request)
    {
        $input = Input::all();
        $user = app(User::class)->verify($input['email'], $input['password']);
        $status = $input['status'];
        $orderID = $input['orderID'];
        if(!empty($orderID) && !empty($user->id)){
            $order = ShopOrder::find($orderID);
            if(!empty($order->id)){
                $order->updateStatus($status);
                return [''];
            }

        }

    }

}