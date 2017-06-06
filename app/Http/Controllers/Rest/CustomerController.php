<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Rest;

use App\Models\Frontend\ShopCustomer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        $input = $request->get('input');
        $customers = ShopCustomer::query()->select(['id', \DB::raw('CONCAT(name, "-", phone, "-", email) AS name')])
            ->where('email', 'like','%'.$input.'%')
            ->orWhere('name', 'like','%'.$input.'%')
            ->orWhere('phone', 'like','%'.$input.'%')
            ->limit(5)
            ->pluck('name', 'id');
        return $customers;
    }

    public function get(Request $request)
    {
        $cid = $request->get('cid');
        if(!empty($cid)){
            $customer = ShopCustomer::find($cid);
            return $customer;
        }
    }
}