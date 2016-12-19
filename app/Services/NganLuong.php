<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 6/16/2016
 * Time: 4:47 PM
 */

namespace App\Services;



class NganLuong
{
    const PRICE_LIST = [2000, 50000, 100000, 200000, 500000];
    const METHOD_BANKING = 1;
    const METHOD_MOBILE_CARD = 2;
    const METHOD_SMS = 3;
    protected $nlcheckout;

    public function __construct()
    {
        if (!defined('URL_API')) {
            define('URL_API', \Config::get('site.nganluong.NL_URL_API'));
        } // Đường dẫn gọi api
        if (!defined('RECEIVER')) {
            define('RECEIVER', \Config::get('site.nganluong.NL_RECEIVER'));
        } // Email tài khoản ngân lượng
        if (!defined('MERCHANT_ID')) {
            define('MERCHANT_ID', \Config::get('site.nganluong.NL_MERCHANT_ID'));
        } // Mã merchant kết nối
        if (!defined('MERCHANT_PASS')) {
            define('MERCHANT_PASS', \Config::get('site.nganluong.NL_MERCHANT_PASS'));
        } // Mật khẩu kết nôi
    }

    public function payByBank($data)
    {
        if ($data) {
            if (!class_exists('NL_CheckOutV3')) {
                include(app_path('Libraries/nganluong/bank/includes/NL_Checkoutv3.php'));
            }
            if (empty($this->nlcheckout)) {
                $this->nlcheckout = new \NL_CheckOutV3(MERCHANT_ID, MERCHANT_PASS, RECEIVER, URL_API);
            }

            $total_amount = $data['total_amount'];
            $array_items = array();
            $payment_method = $data['option_payment'];
            $bank_code = $data['bankcode'];
            $order_code = $data['transaction_code'];

            $payment_type = '';
            $discount_amount = 0;
            $order_description = '';
            $tax_amount = 0;
            $fee_shipping = 0;
            $return_url = $data['return_url'];
            $cancel_url = urlencode($data['cancel_url']);

            $buyer_fullname = $data['buyer_fullname'];
            $buyer_email = $data['buyer_email'];
            $buyer_mobile = $data['buyer_mobile'];

            $buyer_address = '';

            if ($payment_method != '' && $buyer_email != "" && $buyer_mobile != "" && $buyer_fullname != "" && filter_var($buyer_email, FILTER_VALIDATE_EMAIL)) {
                if ($payment_method == "VISA") {
                    $nl_result = $this->nlcheckout->VisaCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount,
                        $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                        $buyer_address, $array_items, $bank_code);

                } elseif ($payment_method == "NL") {
                    $nl_result = $this->nlcheckout->NLCheckout($order_code, $total_amount, $payment_type, $order_description, $tax_amount,
                        $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                        $buyer_address, $array_items);

                } elseif ($payment_method == "ATM_ONLINE" && $bank_code != '') {
                    $nl_result = $this->nlcheckout->BankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount,
                        $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile,
                        $buyer_address, $array_items);
                } elseif ($payment_method == "NH_OFFLINE") {
                    $nl_result = $this->nlcheckout->officeBankCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                } elseif ($payment_method == "ATM_OFFLINE") {
                    $nl_result = $this->nlcheckout->BankOfflineCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);

                } elseif ($payment_method == "IB_ONLINE") {
                    $nl_result = $this->nlcheckout->IBCheckout($order_code, $total_amount, $bank_code, $payment_type, $order_description, $tax_amount, $fee_shipping, $discount_amount, $return_url, $cancel_url, $buyer_fullname, $buyer_email, $buyer_mobile, $buyer_address, $array_items);
                }
            }
            //var_dump($nl_result); die;
            if ($nl_result->error_code == '00') {
                //Cập nhât order với token  $nl_result->token để sử dụng check hoàn thành sau này
                return ['code' => 0, 'url' => (string) $nl_result->checkout_url];
                header('Location: ' . (string)$nl_result->checkout_url);
                exit;
            } else {
                return ['code' => $nl_result->error_code, 'message' => [$nl_result->error_message]];
            }

        }
    }

    public function payByMobiCard($data)
    {
        if (!empty($data)) {
            include(app_path('Libraries/nganluong/card/config.php'));
            include(app_path('Libraries/nganluong/card/includes/MobiCard.php'));
            $soseri = $data['txtSoSeri'];
            $sopin = $data['txtSoPin'];
            $type_card = $data['select_method'];
            //Tiến hành kết nối thanh toán Thẻ cào.
            $call = new \MobiCard();
            $rs = new \Result();
            $coin1 = rand(10, 999);
            $coin2 = rand(0, 999);
            $coin3 = rand(0, 999);
            $coin4 = rand(0, 999);
            $ref_code = $coin4 + $coin3 * 1000 + $coin2 * 1000000 + $coin1 * 100000000;
            $ref_code = $data['transaction_code'];

            $buyer_fullname = $data['buyer_fullname'];
            $buyer_email = $data['buyer_email'];
            $buyer_mobile = $data['buyer_mobile'];

            $rs = $call->CardPay($sopin, $soseri, $type_card, $ref_code, $buyer_fullname, $buyer_mobile, $buyer_email);
            if ($rs->error_code == '00') {
                // Cập nhật data tại đây
                $return = ['code' => 0, 'message' => 'You have paid {card_amount} successfully into your account', 'card_amount' => $rs->card_amount];
            } else {
                $return = ['code' => $rs->error_code, 'message' => [$rs->error_message]];
            }
            return $return;
        }
    }

    public function getTransactionDetail($token)
    {
        return $this->nlcheckout->GetTransactionDetail($token);
    }

}