<?php

namespace App\Models\Frontend;

use App\Models\ShopOrder as Model;

class ShopOrder extends Model
{
    const INVOICE_PREFIX = 'GLAB-';
    const COUNTRY_VN = 230;
    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes = [], array $values = [])
    {
        if(!empty($attributes)){
            $instance = $this->firstOrNew($attributes);
        }else{
            $instance = $this;
        }
        $instance->processingSave($values);
        $instance->fill($values);
        $validate = $instance->validate($instance->attributes);
        if ($validate->passes()) {
            $instance->save();
            $invID = self::INVOICE_PREFIX.date('Ymd').'-'.str_pad($instance->id, 4, '0', STR_PAD_LEFT);
            $record = $this->find($instance->id);
            $record->update(['invoice_code'=>$invID]);
            return $instance;
        }else{
            return $validate->getMessageBag();
        }
    }

    public function generateInvoicePrefix()
    {
        $invID = self::INVOICE_PREFIX.date('Ymd');
        return $invID;
    }

    public function processingSave($values)
    {
        $this->attributes['invoice_code'] = $this->generateInvoicePrefix();
        $this->attributes['store_id'] = '1';
        $this->attributes['store_name'] = 'GLABVN';
        $this->attributes['store_url'] = 'http://glab.vn';
        $this->attributes['user_id'] = auth()->id();
        $this->attributes['customer_id'] = null;
        $this->attributes['customer_group_id'] = null;
        $this->attributes['billing_country_id'] = self::COUNTRY_VN;
        $this->attributes['shipping_country_id'] = self::COUNTRY_VN;
//        $this->attributes['payment_method'] = 'Cash On Delivery';
//        $this->attributes['payment_method_id'] = '1';
//        $this->attributes['payment_code'] = 'ACB';
        $this->attributes['shipper_id'] = '5';
        $this->attributes['total_price'] = '30000000';
        $this->attributes['total_tax'] = '1000000';
        $this->attributes['total_shipping'] = '500000';
        $this->attributes['total'] = '31500000';
        $this->attributes['order_status_id'] = '1';
        $this->attributes['affiliate_id'] = '1';
        $this->attributes['commission'] = '0';
        $this->attributes['marketing_id'] = '1';
        $this->attributes['tracking'] = '';
        $this->attributes['language_id'] = '1';
        $this->attributes['currency_id'] = '1';
        $this->attributes['currency_code'] = 'USD';
        $this->attributes['currency_value'] = '1.00000000';
        $this->attributes['ip'] = '';
        $this->attributes['forwarded_ip'] = '';
        $this->attributes['user_agent'] = '';
        $this->attributes['accept_language'] = '';
        /*
         * Save infomation custommer
         */
    }
}
