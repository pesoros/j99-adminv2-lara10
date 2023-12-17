<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Dashboard extends Model
{
    public function scopeGetDashBusList($query)
    {
        $query = DB::table('v2_bus AS bus')
            ->select('bus.uuid','bus.name')
            ->orderBy('bus.status','desc')
            ->orderBy('bus.name')
            ->get();

        return $query;
    }
    public function scopeGetDashBusAgenda($query, $bus_uuid)
    {
        $start = Carbon::now();
        $finish = Carbon::now()->addDays(90);
        $query = DB::table("v2_book_bus AS bookbus")
            ->select('bus.uuid','book.start_date','book.finish_date','customer.name AS customername')
            ->join('v2_book AS book', 'book.uuid', '=', 'bookbus.book_uuid')
            ->join('v2_bus AS bus', 'bus.uuid', '=', 'bookbus.bus_uuid')
            ->leftJoin('v2_customer AS customer', 'customer.uuid', '=', 'book.customer_uuid')
            ->whereBetween('book.start_date',[$start,$finish])
            ->where('bookbus.bus_uuid',$bus_uuid)
            ->get();

        return $query;
    }
}
