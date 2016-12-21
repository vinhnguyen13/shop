<?php

namespace App\Models\Frontend;

use App\Models\ShopOrder as Model;

class ShopOrder extends Model
{
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
        $this->attributes['invoice_no'] = '';
        $this->attributes['invoice_prefix'] = '';
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
        $this->attributes['payment_address_1'] = '';
        $this->attributes['payment_address_2'] = '';
        $this->attributes['payment_city'] = '';
        $this->attributes['payment_postcode'] = '';
        $this->attributes['payment_country'] = '';
        $this->attributes['payment_country_id'] = '';
        $this->attributes['payment_zone'] = '';
        $this->attributes['payment_zone_id'] = '';
        $this->attributes['payment_address_format'] = '';
        $this->attributes['payment_custom_field'] = '';
        $this->attributes['payment_method'] = '';
        $this->attributes['payment_code'] = '';
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
        $this->attributes['currency_code'] = '';
        $this->attributes['currency_value'] = '';
        $this->attributes['ip'] = '';
        $this->attributes['forwarded_ip'] = '';
        $this->attributes['user_agent'] = '';
        $this->attributes['accept_language'] = '';

    }
}
