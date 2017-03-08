<?php

namespace App\Http\Controllers\Backend;

use App\Services\RevenueService;
use Illuminate\Http\Request;
use Input;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $all = Input::all();
        $orders = app(RevenueService::class)->gridRevenue($all);
        if ($request->ajax()) {
            return view('revenue.partials.grid-revenue', compact('orders'));
        }else{
            return view('revenue.index', compact('orders'));
        }
    }

    public function getPaymentConsignment(Request $request)
    {
        $all = Input::all();
        $orders = app(RevenueService::class)->gridPaymentConsignment($all);
        if ($request->ajax()) {
            return view('revenue.partials.grid-payment-consignment', compact('orders'));
        }
    }

}
