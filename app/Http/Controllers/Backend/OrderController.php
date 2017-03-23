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
use App\Services\Payment;
use Illuminate\Http\Request;
use Input;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopOrder::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('order.index', compact('grid'));
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
                $order->order_status_id = $status;
                $order->save();
                app(Payment::class)->processingSaveOrderProduct($order);
            }

        }

    }

}