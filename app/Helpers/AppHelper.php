<?php
namespace App\Helpers;

use DB;
use Symfony\Component\VarDumper\VarDumper;

/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 9/7/2016
 * Time: 1:53 PM
 */
class AppHelper
{
	const STATUS_DISABLE = 0;
	const STATUS_ENABLE = 1;
	private $breadcrumbs = [];

    public static function setReturnUrl($url, $notUrl = [])
    {
        if(!in_array($url, $notUrl) && !\Request::ajax() && !\Request::isMethod('post')){
            \Session::put('returnUrl', $url);
        }
    }

	public function setBreadcrumb($item)
	{
		$this->breadcrumbs[] = $item;
		$old = \Session::get('breadcrumbs');
		if(!empty($old)){
			$breadcrumbs = $old + $item;
//			VarDumper::dump($old);
			\Session::flash('breadcrumbs', $breadcrumbs);
		}else{
			\Session::flash('breadcrumbs', $item);
		}
	}

	public function getBreadcrumb()
	{
		$breadcrumbs = \Session::get('breadcrumbs');
		if(!empty($breadcrumbs)){
			\Session::remove('breadcrumbs');
			return $breadcrumbs;
		}
	}

	/**
	 * @param null $id
	 * @return array
	 */
	public static function statusLabel($id = null)
	{
		$data = [
			self::STATUS_ENABLE => 'Enable',
			self::STATUS_DISABLE => 'Disable',
		];

		if ($id !== null && isset($data[$id])) {
			return $data[$id];
		} else {
			return $data;
		}
	}

	/**
	 * @param null $id
	 * @return array
	 */
	public static function yesNoLabel($id = null)
	{
		$data = [
			self::STATUS_ENABLE => 'Yes',
			self::STATUS_DISABLE => 'No',
		];

		if ($id !== null && isset($data[$id])) {
			return $data[$id];
		} else {
			return $data;
		}
	}
}