<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopProductSpecial extends Model
{
    use HasValidator;
    protected $table = 'shop_product_special';
    protected $fillable = ['product_id', 'customer_group_id', 'priority', 'price', 'date_start', 'date_end'];
    public $timestamps = false;

    public function rules()
    {
        return [
            'price' => 'required',
            'date_start' => 'required',
            'date_end' => 'required',
        ];
    }
}
