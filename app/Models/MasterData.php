<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterData extends Model
{
    public function scopeGetMasterBusList($query)
    {
        $query = DB::table("v2_bus AS bus")
            ->select('bus.uuid','bus.name','bus.registration_number','bus.brand','bus.model','bus.status','class.name AS class')
            ->join("v2_class AS class", "class.uuid", "=", "bus.class_uuid")
            ->orderBy('bus.created_at')
            ->get();

        return $query;
    }

    public function scopeGetMasterClassList($query)
    {
        $query = DB::table("v2_class")
            ->select('id','uuid','name','seat')
            ->orderBy('id')
            ->get();

        return $query;
    }

    public function scopeGetMasterFacilities($query)
    {
        $query = DB::table("v2_facilities")
            ->select('id','name')
            ->orderBy('id')
            ->get();

        return $query;
    }

    public function scopeSaveMasterBus($query, $data)
    {
        $query = DB::table("v2_bus")->insert($data);

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

    public function scopeSaveMasterFacility($query, $data)
    {
        $query = DB::table("v2_facilities")->insert($data);

        return $query;
    }

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
}
