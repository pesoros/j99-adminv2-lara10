<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    public function scopeGetUserRoleInfo($query, $datas)
    {
        $email = isset($datas['email']) ? $datas['email'] : '';

        $query = DB::table("users")
            ->select('users.role_id','role.title')
            ->join("v2_role AS role", "role.id", "=", "users.role_id")
            ->where('users.email', $email)
            ->first();

        return $query;
    }

    public function scopeGetMenu($query, $datas)
    {
        $role_id = isset($datas['role_id']) ? $datas['role_id'] : '';

        $query = DB::table("v2_menu AS menu")
            ->select('menu.id', 'menu.title', 'menu.url', 'menu.icon')
            ->join("v2_permission AS perm", "perm.slug", "=", "menu.slug")
            ->join("v2_role_permission AS roleperm", "roleperm.permission_id", "=", "perm.id")
            ->where('roleperm.role_id', $role_id)
            ->where('perm.access', 'index')
            ->where('menu.parent_id', NULL)
            ->where('perm.status', 1)
            ->orderBy('menu.order')
            ->get();

        return $query;
    }

    public function scopeGetChildMenu($query, $datas)
    {
        $parent_id = isset($datas['parent_id']) ? $datas['parent_id'] : '';
        $role_id = isset($datas['role_id']) ? $datas['role_id'] : '';

        $query = DB::table("v2_menu AS menu")
            ->select('menu.id', 'menu.title', 'menu.url', 'menu.icon')
            ->join("v2_permission AS perm", "perm.slug", "=", "menu.slug")
            ->join("v2_role_permission AS roleperm", "roleperm.permission_id", "=", "perm.id")
            ->where('roleperm.role_id', $role_id)
            ->where('perm.access', 'show')
            ->where('menu.parent_id', $parent_id)
            ->where('perm.status', 1)
            ->orderBy('menu.order')
            ->get();

        return $query;
    }

    public function scopeGetRoleAccess($query, $datas)
    {
        $role_id = isset($datas['role_id']) ? $datas['role_id'] : '';

        $query = DB::table("v2_role_permission AS roleperm")
            ->select(DB::raw("CONCAT(perm.slug,' ',perm.access) as slugaccess"))
            ->join("v2_permission AS perm", "perm.id", "=", "roleperm.permission_id")
            ->where('roleperm.role_id', $role_id)
            ->where('perm.access', '!=' ,'index')
            ->where('perm.status', 1)
            ->orderBy('perm.slug')
            ->get();

        return collect($query)->pluck('slugaccess')->toArray();
    }
}
