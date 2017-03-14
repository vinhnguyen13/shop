<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPayment extends Model
{
    protected $table = 'shop_payment';

    const KEY_CASHONDELIVERY = 'CashOnDelivery';
    const KEY_ATM_ONLINE = 'ATM_ONLINE';
    const KEY_IB_ONLINE = 'IB_ONLINE';
    const KEY_ATM_OFFLINE = 'ATM_OFFLINE';
    const KEY_VISA = 'VISA';
    const KEY_PAYATSTORE = 'PayAtStore';
}
