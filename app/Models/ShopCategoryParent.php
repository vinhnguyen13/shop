<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopCategoryParent extends Model
{
    protected $table = 'shop_category_parent';
    protected $fillable = ['category_id', 'parent_id'];
    public $timestamps = false;

}
