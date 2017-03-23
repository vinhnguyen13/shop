<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 6/16/2016
 * Time: 4:47 PM
 */

namespace App\Services;

use App\Models\CpCode;
use App\Models\Frontend\ShopCustomer;
use App\Models\Frontend\ShopOrder;
use App\Models\Frontend\ShopOrderDetail;
use App\Models\Frontend\ShopProduct;
use App\Models\ShopOrderProduct;
use App\Models\ShopOrderStatus;
use App\Models\ShopPayment;
use App\Models\ShopProductDetail;
use App\Models\ShopShipFee;
use DB;
use Session;

class Payment
{
    const INVOICE_PREFIX = 'GLAB-';
    const COUNTRY_VN = 230;
    const TYPESTEP_NEXT = 'next';
    const TYPESTEP_FIRST = 'first';

    public $checkoutSteps = [
        1=>'step1',
        2=>'step2',
        3=>'step3'
    ];
    public $checkoutViews = [
        'step1'=>'member',
        'step2'=>'shipping-info',
        'step3'=>'payment',
    ];

    private $errors = [];

    /**
     * @param $detailID
     * @param $quantity
     * @return array|mixed
     */
    public function addCart($productID, $detailID, $size, $quantity){
        $product = ShopProduct::find($productID);
        $totalDetail = $product->countDetailsBySize($size);
        if($quantity > $totalDetail){
            return false;
        }
        $cart = [];
        if (Session::has('cart')) {
            $cart = Session::get('cart');
        }
        $key = $productID.'-'.$size;
        if(!empty($cart[$key])){
            unset($cart[$key]);
        }
        $item = [
            'productID'=>$productID,
            'detailID'=>$detailID,
            'size'=>$size,
            'quantity'=>$quantity,
        ];
        $cart[$key] = $item;
        Session::put('cart', $cart);
        return $cart;

    }

    /**
     * @return bool|mixed
     */
    public function getCart(){
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            return $cart;
        }
        return false;
    }

    /**
     * @param $detailID
     * @return bool|mixed
     */
    public function removeCart($productID, $size){
        if (Session::has('cart')) {
            $cart = Session::get('cart');
            $key = $productID.'-'.$size;
            if(!empty($cart[$key])){
                unset($cart[$key]);
                Session::put('cart', $cart);
                return $cart;
            }
        }
        return false;
    }

    /**
     * @return bool
     */
    public function removeCartAll(){
        if (Session::has('cart')) {
            Session::remove('cart');
        }
        return false;
    }

    /**
     * @param $detailID
     * @param $quantity
     * @return array|mixed
     */
    public function addCheckoutInfo($data){
        $checkoutInfo = [];
        if (Session::has('checkoutInfo')) {
            $checkoutInfo = Session::get('checkoutInfo');
        }
        if(!empty($data)){
            foreach($data as $key=>$value){
                $checkoutInfo[$key] = $value;
            }
        }
        Session::put('checkoutInfo', $checkoutInfo);
        return $checkoutInfo;

    }

    /**
     * @return bool|mixed
     */
    public function getCheckoutInfo(){
        if (Session::has('checkoutInfo')) {
            $checkoutInfo = Session::get('checkoutInfo');
            return $checkoutInfo;
        }
        return false;
    }

    /**
     * @return bool
     */
    public function removeCheckoutInfo(){
        if (Session::has('checkoutInfo')) {
            Session::remove('checkoutInfo');
        }
        return false;
    }

    public function processingSaveOrderProduct($order){
        if ($order->order_status_id != ShopOrderStatus::STT_COMPLETE) {
            return false;
        }
        /*
         * Save shop_order_product
         */
        $orderDetails = ShopOrderDetail::query()->where(['order_id'=>$order->id])->get();
        $pids = null;
        if(!empty($orderDetails)){
            foreach($orderDetails as $orderDetail) {
                $product = ShopProduct::find($orderDetail->product_id);
                $productDetails = $product->getDetailsBySize($orderDetail->size);
                if(!empty($productDetails)) {
                    foreach ($productDetails as $productDetail) {
                        $quantity = 1;
                        $price = $productDetail->getPrice();
                        $subtotalProduct = $price * $quantity;
                        $tax = $product->taxWithPrice($price);
                        $orderProduct = ShopOrderProduct::where(['order_id' => $order->id, 'product_detail_id' => $productDetail->id]);
                        if (empty($orderProduct->id)) {
                            $orderProduct = new ShopOrderProduct();
                            $orderProduct->order_id = $order->id;
                            $orderProduct->product_id = $product->id;
                            $orderProduct->product_detail_id = $productDetail->id;
                        }
                        $orderProduct->order_status_id = $order->order_status_id;
                        $orderProduct->supplier_id = $productDetail->supplier_id;
                        $orderProduct->debt_status = ShopProductDetail::DEBT_PENDING;
                        $orderProduct->product_name = $product->name;
                        $orderProduct->color = $product->color;
                        $orderProduct->sku = $productDetail->sku;
                        $orderProduct->size = $productDetail->size;
                        $orderProduct->quantity = $quantity;
                        $orderProduct->price_in = $productDetail->price_in;
                        $orderProduct->price = $productDetail->price;
                        $orderProduct->total = $subtotalProduct;
                        $orderProduct->tax = $tax;
                        $orderProduct->reward = 0;
                        $orderProduct->save();

                        $productDetail->updateOutOfStock();
                        $pids[] = $product->id;
                    }
                }
            }
        }
        app(ShopProduct::class)->updateStockByIds($pids);
    }

    public function processingSaveOrderDetail($order, $carts){
        if ($order->id) {
            foreach($carts as $pid=>$item){
                $size = $item['size'];
                $quantity = $item['quantity'];
                $productID = $item['productID'];
                $orderDetail = ShopOrderDetail::query()->where(['order_id'=>$order->id, 'product_id'=>$productID, 'size'=>$size])->first();
                if(empty($orderDetail->id)){
                    $orderDetail = new ShopOrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $productID;
                    $orderDetail->size = $size;
                }
                $orderDetail->quantity = $quantity;
                $orderDetail->save();
            }
        }
    }

    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function checkout(array $values = [])
    {
        $carts = $this->getCart();
        if(empty($carts)){
            $messageBag = new \Illuminate\Support\MessageBag();
            $messageBag->add('cart', 'Empty cart');
            return $messageBag;
        }
        DB::beginTransaction();
        try {
            $order = $this->processingFillOrder($values, $carts);
            $order->fill($values);
            $validate = $order->validate($order->getAttributes());
            if ($validate->passes() && empty($order->errors)) {
                $order->save();
                $invID = self::INVOICE_PREFIX.date('Ymd').'-'.str_pad($order->id, 4, '0', STR_PAD_LEFT);
                $order->update(['invoice_code'=>$invID]);
                $this->processingSaveOrderDetail($order, $carts);
                $this->processingSaveOrderProduct($order);
                $this->removeCartAll();
                DB::commit();
                /**
                 * Remove quantity
                 */

                return $order;
            }else{
                $messageBag = $validate->getMessageBag();
                if(!empty($order->errors)){
                    foreach($order->errors as $error){
                        $messageBag->merge($error->getMessages());
                    }
                }
                return $validate->getMessageBag();
            }
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    public function generateInvoicePrefix()
    {
        $invID = self::INVOICE_PREFIX.date('Ymd');
        return $invID;
    }

    public function processingFillOrder($values, $carts)
    {
        $order = app(ShopOrder::class);
        $paymentOption = ShopPayment::where(['key'=>$values['payment_method']])->first();
        $user = auth()->user();
        /*
         * Coupon
         */
        if(!empty($values['coupon_code'])){
            $code = CpCode::query()->where(['code'=>$values['coupon_code']]);
            if(!empty($code)){
                switch($code->amount_type){
                    case CpCode::AMOUNT_TYPE_PERCENT:
                        break;
                    case CpCode::AMOUNT_TYPE_PRICE:
                        break;
                }

            }
        }
        /*
         *  Calculator price of order
         *  Pay at Store: no ship
         */
        $total_price = 0;
        $total_tax = 0;
        $total = 0;
        $total_shipping = 0;
        if($values['payment_method'] == ShopPayment::KEY_PAYATSTORE){
            $order->order_status_id = ShopOrderStatus::STT_COMPLETE;
        }else{
            $shipFee = $this->getShipFeeWithCity($values['shipping_city_id']);
            $total_shipping = $shipFee->value;
            $order->order_status_id = ShopOrderStatus::STT_PENDING;
        }
        if(!empty($carts)){
            foreach($carts as $pid=>$item) {
                $size = $item['size'];
                $quantity = $item['quantity'];
                $product = ShopProduct::find($pid);
                $price = $product->getPriceDefault($size);
                $total_price += $price * $quantity;
                $total_tax += $product->taxWithPrice($price);
            }
            $total = $total_price + $total_shipping + $total_tax;
        }
        /*
         * Save infomation custommer
         */
        $email = !empty($user->email) ? $user->email : $values['email'];
        $customer = ShopCustomer::query()->where(['email'=>$email])->orWhere(['phone'=>$values['shipping_phone']])->toSql();
        if(empty($customer->id)){
            $customer = new ShopCustomer();
            $customer->fill([
                'customer_group_id'=>1,
                'user_id'=>auth()->id(),
                'name'=>$values['shipping_name'],
                'email'=>$email,
                'address'=>$values['shipping_address'],
                'country_id'=>self::COUNTRY_VN,
                'city_id'=>$values['shipping_city_id'],
                'district_id'=>$values['shipping_district_id'],
                'ward_id'=>$values['shipping_ward_id'],
                'tax_code'=>$values['billing_tax_code'],
                'phone'=>$values['shipping_phone'],
                'ip'=>request()->ip(),
            ]);
            $validate = $customer->validate($customer->getAttributes());
            if ($validate->passes()) {
                $customer->save();
            } else {
                $this->errors[] = $validate->getMessageBag();
            }
        }
        /*
         * Fill order
         */

        $order->invoice_code = $this->generateInvoicePrefix();
        $order->store_id = '1';
        $order->store_name = 'GLABVN';
        $order->store_url = 'http://glab.vn';
        if(!empty($user->is_seller)) {
            $order->seller_id = auth()->id();
        }
        if(!empty($customer->id)) {
            $order->customer_id = $customer->id;
            $order->customer_group_id = $customer->customer_group_id;
        }
        $order->billing_country_id = self::COUNTRY_VN;
        $order->shipping_country_id = self::COUNTRY_VN;
        if(!empty($paymentOption->id)){
            $order->payment_method_id = $paymentOption->id;
        }
        $order->shipper_id = null;
        $order->total_price = $total_price;
        $order->total_tax = $total_tax;
        $order->total_shipping = $total_shipping;
        $order->total = $total;
        $order->commission = '0';
        $order->coupon_id = null;
        $order->tracking = uniqid();
        $order->ip = request()->ip();
        $order->forwarded_ip = request()->getClientIp();
        $order->user_agent = request()->header('User-Agent');
        $order->accept_language = app()->getLocale();
        return $order;
    }

    public function getShipFeeWithCity($cityID)
    {
        $shipFee = ShopShipFee::query()->where(['country_id'=>self::COUNTRY_VN, 'city_id'=>$cityID])->where('status', '=', 1)->first();
        if(empty($shipFee)){
            $shipFee = ShopShipFee::query()->where(['country_id'=>self::COUNTRY_VN])->where('status', '=', 1)->whereNull('city_id')->first();
        }
        return $shipFee;
    }

    public function nextStep($currentStep, $type = 'next')
    {
        $key = array_search($currentStep, $this->checkoutSteps);
        if($type == self::TYPESTEP_NEXT) {
            $nextIndex = $key + 1;
        }elseif($type == self::TYPESTEP_FIRST){
            $nextIndex = 1;
        }elseif(is_numeric($type)){
            $nextIndex = $type;
        }
        if(!empty($this->checkoutSteps[$nextIndex])){
            return $this->checkoutSteps[$nextIndex];
        }
        return false;
    }

    public function viewByStep($currentStep)
    {
        return $this->checkoutViews[$currentStep];
    }

    public function isStep($currentStep, $index)
    {
        $key = array_search($currentStep, $this->checkoutSteps);
        if($key == $index){
            return true;
        }
        return false;
    }

}