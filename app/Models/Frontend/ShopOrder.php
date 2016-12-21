<?php

namespace App\Models\Frontend;

use App\Models\ShopOrder as Model;

class ShopOrder extends Model
{
    const invoice_prefix = '';
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
        $validate = $instance->validate($instance->attributes);
        $instance->processingSave($values);
        if ($validate->passes()) {

        }
    }

    public function processingSave($values)
    {
        $invID = 1;
        $invID = str_pad($invID, 4, '0', STR_PAD_LEFT);
        dump($invID);

        $this->attributes['invoice_no'] = '';
        $this->attributes['invoice_prefix'] = 'INV-2013-00';
        $this->attributes['store_id'] = '';
        $this->attributes['store_name'] = '';
        $this->attributes['store_url'] = '';
        $this->attributes['customer_id'] = '';
        $this->attributes['customer_group_id'] = '';
        $this->attributes['firstname'] = '';
        $this->attributes['lastname'] = '';
        $this->attributes['email'] = '';
        $this->attributes['telephone'] = '';
        $this->attributes['fax'] = '';
        $this->attributes['custom_field'] = '';
        $this->attributes['payment_firstname'] = '';
        $this->attributes['payment_lastname'] = '';
        $this->attributes['payment_company'] = '';
        $this->attributes['payment_address_1'] = '27 Le Thi Hong, phuong 17, Go Vap';
        $this->attributes['payment_address_2'] = '27 Le Thi Hong, phuong 17, Go Vap';
        $this->attributes['payment_city'] = 'Ho Chi Minh';
        $this->attributes['payment_postcode'] = '70000';
        $this->attributes['payment_country'] = 'Viet Nam';
        $this->attributes['payment_country_id'] = '230';
        $this->attributes['payment_zone'] = 'Bac Lieu';
        $this->attributes['payment_zone_id'] = '3754';
        $this->attributes['payment_address_format'] = '';
        $this->attributes['payment_custom_field'] = '';
        $this->attributes['payment_method'] = 'Cash On Delivery';
        $this->attributes['payment_code'] = 'cod';
        $this->attributes['shipper_id'] = '';
        $this->attributes['comment'] = '';
        $this->attributes['totalPrice'] = '';
        $this->attributes['totalTax'] = '';
        $this->attributes['totalShipping'] = '';
        $this->attributes['total'] = '';
        $this->attributes['order_status_id'] = '';
        $this->attributes['affiliate_id'] = '';
        $this->attributes['commission'] = '';
        $this->attributes['marketing_id'] = '';
        $this->attributes['tracking'] = '';
        $this->attributes['language_id'] = '';
        $this->attributes['currency_id'] = '';
        $this->attributes['currency_code'] = 'USD';
        $this->attributes['currency_value'] = '1.00000000';
        $this->attributes['ip'] = '';
        $this->attributes['forwarded_ip'] = '';
        $this->attributes['user_agent'] = '';
        $this->attributes['accept_language'] = '';

    }
}
