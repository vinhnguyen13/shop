<?php

namespace App\Models\Frontend;

use App\Models\CpCode;
use App\Models\ShopOrder as Model;
use App\Models\ShopOrderProduct;
use App\Models\ShopOrderStatus;
use App\Models\ShopPayment;
use App\Models\ShopProductDetail;
use App\Models\ShopShipFee;
use DB;

class ShopOrder extends Model
{
    const INVOICE_PREFIX = 'GLAB-';
    const COUNTRY_VN = 230;

    private $errors = [];
    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function processingSaveOrder(array $attributes = [], array $values = [])
    {
        $carts = app(ShopProduct::class)->getCart();
        if(empty($carts)){
            $messageBag = new \Illuminate\Support\MessageBag();
            $messageBag->add('cart', 'Empty cart');
            return $messageBag;
        }
        if(!empty($attributes)){
            $instance = $this->firstOrNew($attributes);
        }else{
            $instance = $this;
        }
        DB::beginTransaction();
        try {
            $instance->processingSave($values);
            $instance->fill($values);
            $validate = $instance->validate($instance->attributes);
            if ($validate->passes() && empty($instance->errors)) {
                $instance->save();
                $invID = self::INVOICE_PREFIX.date('Ymd').'-'.str_pad($instance->id, 4, '0', STR_PAD_LEFT);
                $instance->update(['invoice_code'=>$invID]);
                /*
                 * Save shop_order_product
                 */
                $pids = null;
                if(!empty($carts)){
                    foreach($carts as $productID_detailID=>$item){
                        $productDetail = ShopProductDetail::find($item['detailID']);
                        $product = $productDetail->product;
                        $price = $productDetail->getPrice();
                        $subtotalProduct = $price * $item['quantity'];
                        $tax = $product->taxWithPrice($price);
                        $orderProduct = ShopOrderProduct::where(['order_id'=>$instance->id, 'product_id'=>$product->id]);
                        if(empty($orderProduct->id)){
                            $orderProduct = new ShopOrderProduct();
                            $orderProduct->order_id = $instance->id;
                            $orderProduct->product_id = $product->id;
                        }
                        $orderProduct->order_status_id = $instance->order_status_id;
                        $orderProduct->supplier_id = $productDetail->supplier_id;
                        $orderProduct->product_detail_id = $productDetail->id;
                        $orderProduct->debt_status = ShopProductDetail::DEBT_PENDING;
                        $orderProduct->product_name = $product->name;
                        $orderProduct->color = $product->color;
                        $orderProduct->sku = $productDetail->sku;
                        $orderProduct->size = $productDetail->size;
                        $orderProduct->quantity = $item['quantity'];
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
                app(ShopProduct::class)->updateStockByIds($pids);
                app(ShopProduct::class)->removeCartAll();
                DB::commit();
                /**
                 * Remove quantity
                 */

                return $instance;
            }else{
                $messageBag = $validate->getMessageBag();
                if(!empty($instance->errors)){
                    foreach($instance->errors as $error){
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

    public function processingSave($values)
    {
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
            $this->attributes['order_status_id'] = ShopOrderStatus::STT_COMPLETE;
        }else{
            $shipFee = $this->getShipFeeWithCity($values['shipping_city_id']);
            $total_shipping = $shipFee->value;
            $this->attributes['order_status_id'] = ShopOrderStatus::STT_PENDING;
        }
        $carts = app(ShopProduct::class)->getCart();
        if(!empty($carts)){
            foreach($carts as $productDetailID=>$item){
                $productDetail = ShopProductDetail::find($item['detailID']);
                $product = $productDetail->product;
                $price = $productDetail->getPrice();
                $total_price += $price * $item['quantity'];
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
            $validate = $customer->validate($customer->attributes);
            if ($validate->passes()) {
                $customer->save();
            } else {
                $this->errors[] = $validate->getMessageBag();
            }
        }
        /*
         * Fill order
         */

        $this->attributes['invoice_code'] = $this->generateInvoicePrefix();
        $this->attributes['store_id'] = '1';
        $this->attributes['store_name'] = 'GLABVN';
        $this->attributes['store_url'] = 'http://glab.vn';
        if(!empty($user->is_seller)) {
            $this->attributes['seller_id'] = auth()->id();
        }
        if(!empty($customer->id)) {
            $this->attributes['customer_id'] = $customer->id;
            $this->attributes['customer_group_id'] = $customer->customer_group_id;
        }
        $this->attributes['billing_country_id'] = self::COUNTRY_VN;
        $this->attributes['shipping_country_id'] = self::COUNTRY_VN;
        if(!empty($paymentOption->id)){
            $this->attributes['payment_method_id'] = $paymentOption->id;
        }
        $this->attributes['shipper_id'] = null;
        $this->attributes['total_price'] = $total_price;
        $this->attributes['total_tax'] = $total_tax;
        $this->attributes['total_shipping'] = $total_shipping;
        $this->attributes['total'] = $total;
        $this->attributes['commission'] = '0';
        $this->attributes['coupon_id'] = null;
        $this->attributes['tracking'] = uniqid();
        $this->attributes['ip'] = request()->ip();
        $this->attributes['forwarded_ip'] = request()->getClientIp();
        $this->attributes['user_agent'] = request()->header('User-Agent');
        $this->attributes['accept_language'] = app()->getLocale();

    }

    public function getShipFeeWithCity($cityID)
    {
        $shipFee = ShopShipFee::query()->where(['country_id'=>self::COUNTRY_VN, 'city_id'=>$cityID])->where('status', '=', 1)->first();
        if(empty($shipFee)){
            $shipFee = ShopShipFee::query()->where(['country_id'=>self::COUNTRY_VN])->where('status', '=', 1)->whereNull('city_id')->first();
        }
        return $shipFee;
    }
}
