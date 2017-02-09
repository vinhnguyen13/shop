<?php

namespace App\Http\Controllers\Backend;

use App\Services\RevenueService;
use Illuminate\Http\Request;

class RevenueController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(RevenueService::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('revenue.index', compact('grid'));
        }
    }
}
