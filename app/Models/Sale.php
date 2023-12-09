<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    public function scopeGetCustomerList($query)
    {
        $query = DB::table("v2_customer AS customer")
            ->select('customer.*','city.name AS city_name')
            ->join("v2_area_city AS city", "city.uuid", "=", "customer.city_uuid")
            ->orderBy('customer.name')
            ->get();

        return $query;
    }

    public function scopeGetMasterCityList($query)
    {
        $query = DB::table("v2_area_city")
            ->select('uuid','name')
            ->orderBy('name')
            ->get();

        return $query;
    }

    public function scopeSaveCustomer($query, $data)
    {
        $query = DB::table("v2_customer")->insert($data);

        return $query;
    }
}
