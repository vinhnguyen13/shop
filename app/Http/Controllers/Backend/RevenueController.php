<?php

namespace App\Http\Controllers\Backend;

use App\Services\RevenueService;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $orders = app(RevenueService::class)->gridRevenue();
        if ($request->ajax()) {
            $all = \Input::all();
            return view('revenue.partials.grid-revenue', compact('orders'));
        }else{
            return view('revenue.index', compact('orders'));
        }
    }

    public function getPaymentConsignment(Request $request)
    {
        $orders = app(RevenueService::class)->gridPaymentConsignment();
        if ($request->ajax()) {
            $all = \Input::all();
            return view('revenue.partials.grid-payment-consignment', compact('orders'));
        }
    }

}
