<?php

namespace App\Models\Frontend;

use App\Models\CpCode;
use App\Models\ShopOrder as Model;
use App\Models\ShopOrderProduct;
use App\Models\ShopOrderStatus;
use App\Models\ShopPayment;
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
                $record = $this->find($instance->id);
                $record->update(['invoice_code'=>$invID]);
                /*
                 * Save shop_order_product
                 */
                if(!empty($carts)){
                    $subtotal = 0;
                    $tax = 0;
                    $total = 0;
                    foreach($carts as $productID_sizeID=>$item){
                        $product_details = explode(ShopProduct::SPLIT_PRODUCT_SIZE, $productID_sizeID);
                        $product_id = $product_details[0];
                        $product = ShopProduct::find($product_id);
                        $product->setCart($item['sizeID'], $item['quantity']);
                        $price = $product->priceWithSize();
                        $subtotalProduct = $price * $item['quantity'];
                        $tax = $product->taxWithPrice($price);
                        $orderProduct = ShopOrderProduct::where(['order_id'=>$record->id, 'product_id'=>$product_id]);
                        if(empty($orderProduct->id)){
                            $orderProduct = new ShopOrderProduct();
                            $orderProduct->order_id = $record->id;
                            $orderProduct->product_id = $product_id;
                        }
                        $orderProduct->name = $product->name;
                        $orderProduct->sku = $product->sku_producer;
                        $orderProduct->quantity = $item['quantity'];
                        $orderProduct->price = $price;
                        $orderProduct->total = $subtotalProduct;
                        $orderProduct->tax = $tax;
                        $orderProduct->reward = 0;
                        $orderProduct->save();
                    }
                }
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
         * Save infomation custommer
         */
        $customer = ShopCustomer::query()->where(['email'=>$values['email']])->orWhere(['phone'=>$values['shipping_phone']])->toSql();
        if(empty($customer->id)){
            $customer = new ShopCustomer();
            $customer->fill([
                'customer_group_id'=>1,
                'user_id'=>auth()->id(),
                'name'=>$values['shipping_name'],
                'email'=>$values['email'],
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
         *  Save Order
         */
        $total_price = 0;
        $total_tax = 0;
        $total_shipping = 0;
        $total = 0;
        $carts = app(ShopProduct::class)->getCart();
        if(!empty($carts)){
            foreach($carts as $productID_sizeID=>$item){
                $product_details = explode(ShopProduct::SPLIT_PRODUCT_SIZE, $productID_sizeID);
                $product_id = $product_details[0];
                $product = ShopProduct::find($product_id);
                $product->setCart($item['sizeID'], $item['quantity']);
                $price = $product->priceWithSize();
                $total_price += $price * $item['quantity'];
                $total_tax += $product->taxWithPrice($price);

            }
            $total = $total_price + $total_shipping + $total_tax;
        }

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
        $this->attributes['order_status_id'] = ShopOrderStatus::STT_PENDING;
        $this->attributes['commission'] = '0';
        $this->attributes['coupon_id'] = null;
        $this->attributes['tracking'] = uniqid();
        $this->attributes['ip'] = request()->ip();
        $this->attributes['forwarded_ip'] = request()->getClientIp();
        $this->attributes['user_agent'] = request()->header('User-Agent');
        $this->attributes['accept_language'] = app()->getLocale();

    }
}
