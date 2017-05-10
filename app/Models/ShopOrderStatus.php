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

    /**
     * @param null $id
     * @return array
     */
    public static function getStatus($id = null)
    {
        $data = [
            self::STT_PENDING => 'Pending',
            self::STT_PROCESSING => 'Processing',
            self::STT_SHIPPED => 'Shipped',
            self::STT_COMPLETE => 'Complete',
            self::STT_CANCELED => 'Canceled',
            self::STT_DENIED => 'Denied',
            self::STT_CANCELED_REVERSAL => 'Canceled Reversal',
            self::STT_FAILED => 'Failed',
            self::STT_REFUNDED => 'Refunded',
            self::STT_REVERSED => 'Reversed',
            self::STT_CHARGEBACK => 'Chargeback',
            self::STT_EXPIRED => 'Expired',
            self::STT_PROCESSED => 'Processed',
            self::STT_VOIDED => 'Voided',
        ];

        if ($id !== null && isset($data[$id])) {
            return $data[$id];
        } else {
            return $data;
        }
    }

    public static function getStatusWithCurrentStatus($id = null, $is_admin = true)
    {
        if(!empty($id)){
            $return = [];
            switch($id){
                case self::STT_PENDING:
                    $return = [
                        self::STT_PROCESSING => 'Processing',
                        self::STT_SHIPPED => 'Shipped',
                        self::STT_COMPLETE => 'Complete',
                        self::STT_CANCELED => 'Canceled',
                    ];
                    break;
                case self::STT_PROCESSING:
                    $return = [
                        self::STT_SHIPPED => 'Shipped',
                        self::STT_COMPLETE => 'Complete',
                        self::STT_CANCELED => 'Canceled',
                    ];
                    break;
                case self::STT_SHIPPED:
                    $return = [
                        self::STT_COMPLETE => 'Complete',
                        self::STT_CANCELED => 'Canceled',
                    ];
                    break;
                case self::STT_COMPLETE:
                    $return = [
                        self::STT_CANCELED => 'Canceled',
                    ];
                    break;
            }
            return $return;
        }

    }
}
