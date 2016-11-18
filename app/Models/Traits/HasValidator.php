<?php

/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 9/30/2016
 * Time: 10:49 AM
 */
namespace App\Models\Traits; // *** Adjust this to match your model namespace! ***

trait HasValidator
{
    /**
     * Validate data
     * @param $data
     * @return bool|\Illuminate\Support\MessageBag
     */
    public function validate($data, $rules = array(), $messages = array())
    {
        if (method_exists($this, 'messages')) {
            $messages = $this->messages();
        }
        if (method_exists($this, 'rules')) {
            $rules = $this->rules();
        }
        return \Validator::make($data, $rules, $messages);
    }
}