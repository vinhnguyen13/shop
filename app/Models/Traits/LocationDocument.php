<?php
namespace App\Models\Traits;

use App\Helpers\StringHelper;

trait LocationDocument
{
	public static function buildDocument($item, $districtDoc, $cityDoc) {
		$name = $item->name;
		$nameWithPrefix = "{$item->pre} {$name}";
		$fullName = self::fullName($item->pre, $name, $districtDoc['full_name']);
		$acronym = self::acronym($item);
		$nameFullText = self::standardSearch($nameWithPrefix);
		$acronymFullName1 = "{$acronym} {$cityDoc['s4']}";
		$acronymFullName = "{$acronym} {$districtDoc['s5']}";
		$fullName1 = "{$nameFullText} {$cityDoc['full_name']}";
		$fullNameSearch = "{$nameFullText} {$districtDoc['s9']}";
	
		return [
			'full_name' => $fullName,
			'slug' => $item->slug,
			'city_id' => intval($districtDoc['city_id']),
			'district_id' => intval($districtDoc['district_id']),
			's1' => $name,
			's2' => $name,
			's3' => $nameWithPrefix,
			's4' => $acronym,
			's5' => $acronymFullName1,
			's6' => $acronymFullName,
			's7' => $nameFullText,
			's8' => $fullName1,
			's9' => $fullNameSearch,
			's10' => $fullNameSearch
		];
	}
	
	private static function acronym($item) {
		return StringHelper::acronym($item->name);
	}
	
	private static function standardSearch($s) {
		return StringHelper::standardSearch($s);
	}
	
	private static function fullName($pre, $name, $suffix) {
		return "{$pre} {$name}, {$suffix}";
	}
}




