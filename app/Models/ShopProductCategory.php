<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopProductCategory extends Model
{
    use HasValidator;
    protected $table = 'shop_product_category';
    protected $fillable = ['product_id', 'category_id'];
    public $timestamps = false;

    public function rules()
    {
        return [
            'product_id' => 'required',
            'category_id' => 'required',
        ];
    }
}
