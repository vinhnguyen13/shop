<?php

namespace App\Http\Controllers\Backend;

use App\Services\RevenueService;
use Illuminate\Http\Request;
use Input;

class ProfitController extends Controller
{
    public function index(Request $request)
    {
        app(RevenueService::class)->updateDebtDueDate();
        $all = Input::all();
        $orders = app(RevenueService::class)->gridRevenue($all);
        if ($request->ajax()) {
            return view('profit.partials.grid-profit', compact('orders'));
        }else{
            return view('profit.index', compact('orders'));
        }
    }

    public function debt(Request $request)
    {
        app(RevenueService::class)->updateDebtDueDate();
        $all = Input::all();
        $orders = app(RevenueService::class)->gridRevenue($all);
        if ($request->ajax()) {
            return view('profit.partials.grid-debt', compact('orders'));
        }else{
            return view('profit.debt', compact('orders'));
        }
    }

    public function getDebtPaymentDueDate(Request $request)
    {
        $all = Input::all();
        $orders = app(RevenueService::class)->gridDebtPaymentDueDate($all);
        if ($request->ajax()) {
            return view('profit.partials.grid-debt-payment-due-date', compact('orders'));
        }
        if($request->get('print')){
            return view('profit.print.grid-debt-payment-due-date', compact('orders'));
        }
    }

}
