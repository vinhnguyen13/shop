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
            $invoice = [
                'invoice_number'=>'GLAB-1231243',
                'product_name'=>'product_name',
                'subtotal'=>'4000',
                'ship_amount'=>'500',
                'discount_amount'=>'300',
                'total'=>'4200',
                'orders'=>[
                    [
                        'product_name'=>'Nike',
                        'product_size'=>'13',
                        'product_qty'=>'2',
                        'product_price'=>'2000',
                        'product_total'=>'4000',
                    ],
                ],
                'customer'=>[
                    'name'=>'Vinh Nguyen',
                    'email'=>'vinh@abc.com',
                    'phone'=>'223436456456',
                    'address'=>'21 Hai Ba Trung',
                ]
            ];
            return view('page.partials.print-invoice', compact('invoice'));
        }else{
            return view('page.print-invoice');
        }
    }

}