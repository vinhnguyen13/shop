<?php

namespace App\Models\Frontend;

use App\Models\ShopOrder as Model;

class ShopOrder extends Model
{
    const INVOICE_PREFIX = 'GLAB-';
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
        $instance->fill($values);
        $instance->processingSave($values);
        $validate = $instance->validate($instance->attributes);
        if ($validate->passes()) {
//            echo "<pre>";
//            print_r($instance->getAttributes());
//            echo "</pre>";
//            exit;
            $instance->save();
            $invID = self::INVOICE_PREFIX.date('Ymd').'-'.str_pad($instance->id, 4, '0', STR_PAD_LEFT);
            $record = $this->find($instance->id);
            $record->update(['invoice_prefix'=>$invID]);
            return $instance;
        }else{
            return $validate->getMessageBag();
        }
    }

    public function generateInvoicePrefix()
    {
        $maxID = $this->query()->max('id');
//        $invID = str_pad(($maxID+1), 4, '0', STR_PAD_LEFT);
        $invID = ($maxID+1);
        $invID = self::INVOICE_PREFIX.date('Ymd');
        return $invID;
    }

    public function processingSave($values)
    {
        $attributesSet['invoice_no'] = '';
        $attributesSet['invoice_prefix'] = $this->generateInvoicePrefix();
        $attributesSet['store_id'] = '1';
        $attributesSet['store_name'] = 'GLABVN';
        $attributesSet['store_url'] = 'http://glab.vn';
        $attributesSet['user_id'] = '90';
        $attributesSet['customer_id'] = '2';
        $attributesSet['customer_group_id'] = '2';
        $attributesSet['name'] = 'Vinh Nguy?n';
        $attributesSet['email'] = 'vinh@dwm.vn';
        $attributesSet['billing_name'] = 'Vinh Nguy?n';
        $attributesSet['billing_address'] = '27 Le Thi Hong';
        $attributesSet['billing_country_id'] = '1';
        $attributesSet['billing_city_id'] = '2';
        $attributesSet['billing_district_id'] = '3';
        $attributesSet['billing_ward_id'] = '4';
        $attributesSet['billing_phone'] = '090812223254';
        $attributesSet['billing_tax_code'] = '230';
        $attributesSet['shipping_name'] = 'Vinh Nguy?n';
        $attributesSet['shipping_address'] = '27 Le Thi Hong';
        $attributesSet['shipping_country_id'] = '1';
        $attributesSet['shipping_city_id'] = '2';
        $attributesSet['shipping_district_id'] = '3';
        $attributesSet['shipping_ward_id'] = '4';
        $attributesSet['shipping_phone'] = '090810020';
        $attributesSet['payment_method'] = 'Cash On Delivery';
        $attributesSet['payment_method_id'] = '1';
        $attributesSet['payment_code'] = 'ACB';
        $attributesSet['shipper_id'] = '5';
        $attributesSet['comment'] = 'Nh? ?�ng gi? nha anh';
        $attributesSet['total_price'] = '30000000';
        $attributesSet['total_tax'] = '1000000';
        $attributesSet['total_shipping'] = '500000';
        $attributesSet['total'] = '31500000';
        $attributesSet['order_status_id'] = '1';
        $attributesSet['affiliate_id'] = '1';
        $attributesSet['commission'] = '0';
        $attributesSet['marketing_id'] = '1';
        $attributesSet['tracking'] = '';
        $attributesSet['language_id'] = '1';
        $attributesSet['currency_id'] = '1';
        $attributesSet['currency_code'] = 'USD';
        $attributesSet['currency_value'] = '1.00000000';
        $attributesSet['ip'] = '';
        $attributesSet['forwarded_ip'] = '';
        $attributesSet['user_agent'] = '';
        $attributesSet['accept_language'] = '';
        $attributes = array_collapse([$attributesSet, $values]);
        $this->setRawAttributes($attributes);
    }
}
