<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrderStatus extends Model
{
    protected $table = 'shop_order_status';

    const STT_PENDING           = 1;
    const STT_PROCESSING        = 2;
    const STT_SHIPPED           = 3;
    const STT_COMPLETE          = 4;
    const STT_CANCELED          = 5;
    const STT_DENIED            = 6;
    const STT_CANCELED_REVERSAL = 7;
    const STT_FAILED            = 8;
    const STT_REFUNDED          = 9;
    const STT_REVERSED          = 10;
    const STT_CHARGEBACK        = 11;
    const STT_EXPIRED           = 12;
    const STT_PROCESSED         = 13;
    const STT_VOIDED            = 14;
}
