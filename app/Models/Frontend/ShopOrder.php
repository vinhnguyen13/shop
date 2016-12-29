<?php

namespace App\Models\Frontend;

use App\Models\ShopOrder as Model;

class ShopOrder extends Model
{
    const invoice_prefix = 'GLAB-HCM-';
    /**
     * Create or update a related record matching the attributes, and fill it with values.
     *
     * @param  array $attributes
     * @param  array $values
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function updateOrCreate(array $attributes, array $values = [])
    {
        $instance = $this->firstOrNew($attributes);
        $instance->fill($values);
        $instance->processingSave($values);
        $validate = $instance->validate($instance->attributes);
        if ($validate->passes()) {
            echo "<pre>";
            print_r(54);
            echo "</pre>";
            exit;
        }else{
            return $validate->getMessageBag();
        }
    }

    public function generateInvoice()
    {
        return 'INV-2013-00';
    }

    public function processingSave($values)
    {
        $invID = 1;
        $invID = str_pad($invID, 4, '0', STR_PAD_LEFT);

        $attributesSet['invoice_no'] = '';
        $attributesSet['invoice_prefix'] = 'INV-2013-00';
        $attributesSet['store_id'] = '';
        $attributesSet['store_name'] = '';
        $attributesSet['store_url'] = '';
        $attributesSet['user_id'] = '';
        $attributesSet['customer_id'] = '';
        $attributesSet['customer_group_id'] = '';
        $attributesSet['name'] = '';
        $attributesSet['email'] = '';
        $attributesSet['billing_name'] = '';
        $attributesSet['billing_address'] = '27 Le Thi Hong, phuong 17, Go Vap';
        $attributesSet['billing_country_id'] = '';
        $attributesSet['billing_city_id'] = '';
        $attributesSet['billing_district_id'] = 'Ho Chi Minh';
        $attributesSet['billing_ward_id'] = '70000';
        $attributesSet['billing_phone'] = 'Viet Nam';
        $attributesSet['billing_tax_code'] = '230';
        $attributesSet['shipping_name'] = '';
        $attributesSet['shipping_address'] = '27 Le Thi Hong, phuong 17, Go Vap';
        $attributesSet['shipping_country_id'] = '';
        $attributesSet['shipping_city_id'] = '';
        $attributesSet['shipping_district_id'] = 'Ho Chi Minh';
        $attributesSet['shipping_ward_id'] = '70000';
        $attributesSet['shipping_phone'] = '090810020';
        $attributesSet['payment_method'] = 'Cash On Delivery';
        $attributesSet['payment_code'] = 'cod';
        $attributesSet['shipper_id'] = '';
        $attributesSet['comment'] = '';
        $attributesSet['total_price'] = '';
        $attributesSet['total_price'] = '';
        $attributesSet['total_price'] = '';
        $attributesSet['total'] = '';
        $attributesSet['order_status_id'] = '';
        $attributesSet['affiliate_id'] = '';
        $attributesSet['commission'] = '';
        $attributesSet['marketing_id'] = '';
        $attributesSet['tracking'] = '';
        $attributesSet['language_id'] = '';
        $attributesSet['currency_id'] = '';
        $attributesSet['currency_code'] = 'USD';
        $attributesSet['currency_value'] = '1.00000000';
        $attributesSet['ip'] = '';
        $attributesSet['forwarded_ip'] = '';
        $attributesSet['user_agent'] = '';
        $attributesSet['accept_language'] = '';
        $attributes = array_collapse([$attributesSet, \Input::all()]);
        dump(\Input::all());
        $this->attributes = $attributes;


    }
}
