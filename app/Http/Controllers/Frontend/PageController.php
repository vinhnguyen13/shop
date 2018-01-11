<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Frontend;

use App\Models\Frontend\ShopProduct;

class PageController extends Controller
{
    public function about()
    {
        return view('page.about');
    }

    public function scannerBarcode()
    {
        return view('page.scanner-barcode');
    }

    public function instagram()
    {
        return view('page.instagram');
    }
    
    public function printInvoice()
    {
        $print = request('print');
        if(!empty($print)){
            return view('product.payment.print.success', compact('order'));
        }else{
            return view('page.print-invoice');
        }
    }

}