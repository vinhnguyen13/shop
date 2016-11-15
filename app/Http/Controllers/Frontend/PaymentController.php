<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 9/16/2016
 * Time: 11:27 AM
 */

namespace App\Http\Controllers\Frontend;

use Illuminate\Http\Request;
use App;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        return view('payment.index');
    }
}