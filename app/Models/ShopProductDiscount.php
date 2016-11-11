<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopProductDiscount extends Model
{
    use HasValidator;
    protected $table = 'shop_product_discount';
    protected $fillable = ['product_id', 'customer_group_id', 'quantity', 'priority', 'price', 'date_start', 'date_end'];
    public $timestamps = false;

    public function rules()
    {
        return [
            'quantity' => 'required',
            'price' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ];
    }
}
