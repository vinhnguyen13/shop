<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopTaxClass extends Model
{
    protected $table = 'shop_tax_class';
    const TYPE_PERCEN = 'P';
    const TYPE_FLAT = 'F';
}
