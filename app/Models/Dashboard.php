<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
        $query = DB::table("v2_book_bus AS bookbus")
            ->select('bus.uuid','book.start_date','book.finish_date')
            ->join('v2_book AS book', 'book.uuid', '=', 'bookbus.book_uuid')
            ->join('v2_bus AS bus', 'bus.uuid', '=', 'bookbus.bus_uuid')
            ->where('bookbus.bus_uuid',$bus_uuid)
            ->get();

        return $query;
    }
}
