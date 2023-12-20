<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterData extends Model
{

    // BUS
    public function scopeGetMasterBusList($query)
    {
        $query = DB::table("v2_bus AS bus")
            ->select('bus.uuid','bus.name','bus.registration_number','bus.brand','bus.model','bus.status','class.name AS class','class.seat')
            ->join("v2_class AS class", "class.uuid", "=", "bus.class_uuid")
            ->orderBy('bus.created_at')
            ->get();

        return $query;
    }

    public function scopeSaveMasterBus($query, $data)
    {
        $query = DB::table("v2_bus")->insert($data);

        return $query;
    }

    public function scopeGetMasterBus($query, $uuid)
    {
        $query = DB::table("v2_bus AS bus")
            ->select('bus.*','class.name AS class')
            ->join("v2_class AS class", "class.uuid", "=", "bus.class_uuid")
            ->where('bus.uuid', $uuid)
            ->first();

        return $query;
    }

    public function scopeUpdateMasterBus($query, $uuid, $data)
    {
        $query = DB::table("v2_bus")
            ->where('uuid',$uuid)
            ->update($data);

        return $query;
    }

    public function scopeRemoveMasterbus($query, $uuid)
    {
        $query = DB::table("v2_bus")
            ->where('uuid',$uuid)
            ->delete();

        return $query;
    }

    //CITY
    public function scopeGetMasterCityList($query)
    {
        $query = DB::table("v2_area_city AS city")
            ->select('city.uuid','city.name','province.name AS province_name')
            ->join("v2_area_province AS province", "province.uuid", "=", "city.province_uuid")
            ->orderBy('province.name')
            ->orderBy('city.name')
            ->get();

        return $query;
    }

    public function scopeGetMasterProvinceList($query)
    {
        $query = DB::table("v2_area_province")
            ->select('uuid','name')
            ->orderBy('name')
            ->get();

        return $query;
    }

    public function scopeSaveMasterCity($query, $data)
    {
        $query = DB::table("v2_area_city")->insert($data);

        return $query;
    }

    public function scopeGetMasterCity($query, $uuid)
    {
        $query = DB::table("v2_area_city AS city")
            ->where('city.uuid', $uuid)
            ->first();

        return $query;
    }

    public function scopeUpdateMasterCity($query, $uuid, $data)
    {
        $query = DB::table("v2_area_city")
            ->where('uuid',$uuid)
            ->update($data);

        return $query;
    }

    public function scopeRemoveMasterCity($query, $uuid)
    {
        $query = DB::table("v2_area_city")
            ->where('uuid',$uuid)
            ->delete();

        return $query;
    }

    //CLASS
    public function scopeGetMasterClassList($query)
    {
        $query = DB::table("v2_class")
            ->select('id','uuid','name','seat')
            ->orderBy('id')
            ->get();

        return $query;
    }

    public function scopeSaveMasterClass($query, $data)
    {
        $query = DB::table("v2_class")->insert($data);

        return $query;
    }

    public function scopeSaveClassFacilities($query, $data)
    {
        $query = DB::table("v2_class_facilities")->insert($data);

        return $query;
    }

    public function scopeGetMasterClass($query, $uuid)
    {
        $query = DB::table("v2_class AS class")
            ->where('class.uuid', $uuid)
            ->first();

        return $query;
    }

    public function scopeGetMasterClassFacilities($query, $uuid)
    {
        $query = DB::table("v2_class_facilities AS facilities")
            ->where('facilities.class_id', $uuid)
            ->get();

        return $query;
    }

    public function scopeUpdateMasterClass($query, $uuid, $data)
    {
        $query = DB::table("v2_class")
            ->where('uuid',$uuid)
            ->update($data);

        return $query;
    }

    public function scopeCheckClassContains($query, $uuid)
    {
        $query = DB::table("v2_bus")
            ->where('class_uuid',$uuid)
            ->get();

        return $query;
    }

    public function scopeRemoveMasterClass($query, $uuid)
    {
        $query = DB::table("v2_class")
            ->where('uuid',$uuid)
            ->delete();

        return $query;
    }

    public function scopeRemoveClassFacilities($query, $uuid)
    {
        $query = DB::table("v2_class_facilities")
            ->where('class_id',$uuid)
            ->delete();

        return $query;
    }

    //FACILITES
    public function scopeGetMasterFacilitiesList($query)
    {
        $query = DB::table("v2_facilities")
            ->select('id','name')
            ->orderBy('id')
            ->get();

        return $query;
    }

    public function scopeGetMasterFacilities($query, $uuid)
    {
        $query = DB::table("v2_facilities AS facilities")
            ->where('facilities.id', $uuid)
            ->first();

        return $query;
    }

    public function scopeSaveMasterFacilities($query, $data)
    {
        $query = DB::table("v2_facilities")->insert($data);

        return $query;
    }

    public function scopeUpdateMasterFacilities($query, $uuid, $data)
    {
        $query = DB::table("v2_facilities")
            ->where('id',$uuid)
            ->update($data);

        return $query;
    }

    public function scopeCheckFacilitiesContains($query, $uuid)
    {
        $query = DB::table("v2_class_facilities")
            ->where('facilities_id',$uuid)
            ->get();

        return $query;
    }

    public function scopeRemoveMasterFacilities($query, $uuid)
    {
        $query = DB::table("v2_facilities")
            ->where('id',$uuid)
            ->delete();

        return $query;
    }

}
