<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Role extends Model
{
    protected $table = 'v2_role';
    protected $fillable = [
        'uuid',
        'title',
        'slug',
        'description',
    ];

    public function scopeGetRole($query)
    {
        $query = DB::table("v2_role")
            ->select('uuid','title','slug','description')
            ->where('status', 1)
            // ->where('slug','!=', 'super-user')
            ->orderBy('created_at')
            ->get();

        return $query;
    }

    public function scopeGetMenu($query)
    {
        $query = DB::table("v2_menu")
            ->select('title','slug')
            ->where('status', 1)
            ->orderBy('order')
            ->get();

        return $query;
    }

    public function scopeGetAccess($query)
    {
        $query = DB::table("v2_access_name AS acname")
            ->select('name')
            ->orderBy('id')
            ->get();

        return $query;
    }

    public function scopeGetPermission($query, $slug, $access)
    {
        $query = DB::table("v2_permission")
            ->select('id AS permid')
            ->where('slug', $slug)
            ->where('access', $access)
            ->where('status', 1)
            ->orderBy('id')
            ->first();

        return $query;
    }

    public function scopeGetRolePermission($query, $id, $role_uuid)
    {
        $query = DB::table("v2_role_permission as roleperm")
            ->select('roleperm.id')
            ->join("v2_role AS role", "role.id", "=", "roleperm.role_id")
            ->where('roleperm.permission_id', $id)
            ->where('role.uuid', $role_uuid)
            ->exists();

        return $query;
    }
}
