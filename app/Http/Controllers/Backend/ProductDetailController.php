<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 4/19/2016
 * Time: 11:27 AM
 */
namespace App\Http\Controllers\Backend;

use App\Models\Backend\ShopProductDetail;
use Illuminate\Http\Request;
use Input;
use Response;
use Illuminate\Support\Facades\Redirect;

class ProductDetailController extends Controller
{
    public function index(Request $request)
    {
        $grid = app(ShopProductDetail::class)->gridIndex();
        if ($request->ajax()) {
            return $grid->table();
        }else{
            return view('product-detail.index', compact('grid'));
        }
    }

    public function qrcode(Request $request){
        $productDetailID = $request->get('id');
        $productDetail = ShopProductDetail::find($productDetailID);
        if(!empty($productDetail)){
            include(app_path('Libraries/phpqrcode/phpqrcode.php'));
            $text = 'Url: '.$productDetail->product->url().PHP_EOL;
            $text .= 'SKU: '.$productDetail->sku.PHP_EOL;
            $code = \QRcode::png($text); // creates file
            $response = Response::make( $code, 200);
            $response->header("Content-Type", 'image/png');
            return $response;
        }
        return false;
    }
}