<?php

namespace App\Http\Controllers\Backend;

use App\Services\RevenueService;
use Illuminate\Http\Request;
use Input;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        app(RevenueService::class)->updateDebtDueDate();
        $all = Input::all();
        $orders = app(RevenueService::class)->gridRevenue($all);
        if ($request->ajax()) {
            return view('revenue.partials.grid-revenue', compact('orders'));
        }else{
            return view('revenue.index', compact('orders'));
        }
    }

    public function getDebtPaymentDueDate(Request $request)
    {
        $all = Input::all();
        $orders = app(RevenueService::class)->gridDebtPaymentDueDate($all);
        if ($request->ajax()) {
            return view('revenue.partials.grid-debt-payment-due-date', compact('orders'));
        }
        if($request->get('print')){
            return view('revenue.print.grid-debt-payment-due-date', compact('orders'));
        }
    }

}
