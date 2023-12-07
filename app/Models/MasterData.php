<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class MasterData extends Model
{
    public function scopeGetMasterBusList($query)
    {
        $query = DB::table("v2_bus")
            ->select('uuid','name','seat','registration_number','brand','model','status')
            ->orderBy('created_at')
            ->get();

        return $query;
    }
}
