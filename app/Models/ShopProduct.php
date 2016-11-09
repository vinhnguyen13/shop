<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProduct extends Model
{
    protected $table = 'shop_product';

    public function rules()
    {
        return [
            'category_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
        ];
    }
}
