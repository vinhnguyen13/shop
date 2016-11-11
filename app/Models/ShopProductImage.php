<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopProductImage extends Model
{
    protected $table = 'shop_product_image';
    protected $fillable = ['product_id', 'image', 'folder', 'order', 'uploaded_at'];
    public $timestamps = false;
}
