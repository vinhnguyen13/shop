<?php
/**
 * Created by PhpStorm.
 * User: vinhnguyen
 * Date: 5/29/2017
 * Time: 6:31 PM
 */

namespace App\Models\Traits;


use App\Models\SysCity;
use App\Models\SysCountry;
use App\Models\SysDistrict;
use App\Models\SysStreet;
use App\Models\SysWard;

trait Location
{
    public function locationToText()
    {
        $location = [];
        if (!empty($this->address)) {
            $location[] = $this->address;
        }
        if (!empty($this->street_id)) {
            $street = SysStreet::find($this->street_id);
            if (!empty($street)) {
                $location[] = $street->name;
            }
        }
        if (!empty($this->ward_id)) {
            $ward = SysWard::find($this->ward_id);
            if (!empty($ward)) {
                $location[] = $ward->name;
            }
        }
        if (!empty($this->district_id)) {
            $district = SysDistrict::find($this->district_id);
            if (!empty($district)) {
                $location[] = $district->name;
            }
        }
        if (!empty($this->city_id)) {
            $city = SysCity::find($this->city_id);
            if (!empty($city)) {
                $location[] = $city->name;
            }
        }
        return implode(', ', $location);
    }

}