<?php	
	
	header("Content-Type: text/html; charset=utf-8");	
	define('NGANLUONG_URL_CARD_POST', 'https://www.nganluong.vn/mobile_card.api.post.v2.php');
	define('NGANLUONG_URL_CARD_SOAP', 'https://nganluong.vn/mobile_card_api.php?wsdl');
	class ConfigNL
	{
		  public static $_FUNCTION = "CardCharge";
		  public static $_VERSION = "2.0";
		  //Thay đổi 3 thông tin ở phía dưới
		  public static $_MERCHANT_ID = MERCHANT_ID;
		  public static $_MERCHANT_PASSWORD = MERCHANT_PASS;
		  public static $_EMAIL_RECEIVE_MONEY = RECEIVER;
	}
	
?>