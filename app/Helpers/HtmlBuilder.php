<?php
namespace App\Helpers;

class HtmlBuilder extends \Collective\Html\HtmlBuilder {
	public function toJson($obj) {
		$jsonString = json_encode($obj);
		
		$jsonString = preg_replace_callback('/\:\"js\((.*?)\)\"/', function($matches) {
			$unescape = json_decode('{"text":"' . $matches[1] . '"}');
			return ':' . $unescape->text;
		}, $jsonString);
		
		return $jsonString;
	}
	
	public static function formatNumber($num, $round = false) {
		if(!is_numeric($num)) {
			return null;
		}
	
		if($round !== false) {
			$num = round($num, $round);
		}
	
		$parts = explode('.', $num);
	
		$parts[0] = number_format($parts[0]);
	
		return implode('.', $parts);
	}
	
	public static function formatCurrency($num, $round = 2, $roundBelowMillion = 0) {
		if(!is_numeric($num)) {
			return null;
		}
	
		if($num < 1000000) {
			return self::formatNumber($num, $roundBelowMillion);
		}
	
		$f = round(($num / 1000000), $round);
		$unit = 'million';
	
		if($f >= 1000) {
			$f = round(($f / 1000), $round);
			$unit = 'billion';
		}
	
		return self::formatNumber($f) . ' <span class="txt-unit">' . $unit . '</span>';
	}
}