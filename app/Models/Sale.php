<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Sale extends Model
{
    public function scopeGetCustomerList($query)
    {
        $query = DB::table("v2_customer AS customer")
            ->select('customer.*', 'city.name AS city_name')
            ->join("v2_area_city AS city", "city.uuid", "=", "customer.city_uuid")
            ->orderBy('customer.name')
            ->get();

        return $query;
    }

    public function scopeGetMasterCityList($query)
    {
        $query = DB::table("v2_area_city")
            ->select('uuid', 'name')
            ->orderBy('name')
            ->get();

        return $query;
    }

    public function scopeSaveCustomer($query, $data)
    {
        $query = DB::table("v2_customer")->insert($data);

        return $query;
    }

    public function scopeGetCustomer($query, $uuid)
    {
        $query = DB::table("v2_customer AS customer")
            ->select('customer.*', 'city.name AS city_name')
            ->join("v2_area_city AS city", "city.uuid", "=", "customer.city_uuid")
            ->where("customer.uuid", $uuid)
            ->first();

        return $query;
    }

    public function scopeUpdateCustomer($query, $uuid, $data)
    {
        $query = DB::table("v2_customer")
            ->where('uuid', $uuid)
            ->update($data);

        return $query;
    }

    public function scopeRemoveCustomer($query, $uuid)
    {
        $query = DB::table("v2_customer")
            ->where('uuid', $uuid)
            ->delete();

        return $query;
    }

    public function scopeGetBookList($query)
    {
        $query = DB::table("v2_book AS book")
            ->select(
                'book.uuid',
                'book.booking_code',
                'book.start_date',
                'book.finish_date',
                'book.total_price',
                'customer.name as customer_name',
                'city_from.name as city_from',
                'city_to.name as city_to'
            )
            ->leftJoin("v2_customer AS customer", "customer.uuid", "=", "book.customer_uuid")
            ->leftJoin("v2_area_city AS city_from", "city_from.uuid", "=", "book.departure_city_uuid")
            ->leftJoin("v2_area_city AS city_to", "city_to.uuid", "=", "book.destination_city_uuid")
            ->orderBy('book.created_at', 'desc')
            ->get();

        return $query;
    }

    public function scopeSaveBook($query, $data)
    {
        $query = DB::table("v2_book")->insert($data);

        return $query;
    }

    public function scopeSaveBookBus($query, $data)
    {
        $query = DB::table("v2_book_bus")->insert($data);

        return $query;
    }

    public function scopeUpdateBook($query, $uuid, $data)
    {
        $query = DB::table("v2_book")
            ->where('uuid', $uuid)
            ->update($data);

        return $query;
    }

    public function scopeRemoveBook($query, $uuid)
    {
        $query = DB::table("v2_book")
            ->where('uuid', $uuid)
            ->delete();

        return $query;
    }

    public function scopeGetBook($query, $uuid)
    {
        $query = DB::table("v2_book AS book")
            ->select(
                'book.created_at',
                'book.uuid',
                'book.booking_code',
                'book.start_date',
                'book.finish_date',
                'book.pickup_address',
                'book.notes',
                'book.price',
                'book.discount',
                'book.tax',
                'book.total_price',
                'book.notes',
                'book.down_payment',
                'book.final_payment',
                'customer.name AS customer_name',
                'customer.email AS customer_email',
                'customer.phone AS customer_phone',
                'customer.address AS customer_address',
                'city_from.name as city_from',
                'city_to.name as city_to'
            )
            ->leftJoin("v2_customer AS customer", "customer.uuid", "=", "book.customer_uuid")
            ->leftJoin("v2_area_city AS city_from", "city_from.uuid", "=", "book.departure_city_uuid")
            ->leftJoin("v2_area_city AS city_to", "city_to.uuid", "=", "book.destination_city_uuid")
            ->where('book.uuid', $uuid)
            ->orderBy('book.created_at')
            ->first();

        return $query;
    }

    public function scopeRemoveBookBus($query, $uuid)
    {
        $query = DB::table("v2_book_bus")
            ->where('book_uuid', $uuid)
            ->delete();

        return $query;
    }

    public function scopeGetBookBus($query, $book_uuid)
    {
        $query = DB::table("v2_book_bus AS bookbus")
            ->select('bus.name', 'bookbus.price', 'bookbus.bus_uuid', 'class.name as classname', 'class.seat')
            ->join('v2_bus AS bus', 'bus.uuid', '=', 'bookbus.bus_uuid')
            ->join("v2_class AS class", "class.uuid", "=", "bus.class_uuid")
            ->where('bookbus.book_uuid', $book_uuid)
            ->get();

        return $query;
    }
}
