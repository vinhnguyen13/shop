<?php

namespace App\Models;

use App\Models\Traits\HasValidator;
use Illuminate\Database\Eloquent\Model;

class ShopProductSize extends Model
{
    use HasValidator;
    protected $table = 'shop_product_size';
    protected $fillable = ['product_id', 'size', 'price', 'new_status'];
    public $timestamps = false;

    public function rules()
    {
        return [
            'product_id' => 'required',
            'size' => 'required',
            'new_status' => 'required|numeric',
        ];
    }

    public function messages()
    {
        return [
            'size.required' => 'Size is required',
        ];
    }
}
