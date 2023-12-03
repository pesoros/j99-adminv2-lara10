<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\Role;

class RoleController extends Controller
{
    public function listRole()
    {
        $data['title'] = 'Role';
        $data['list'] = Role::getRole();

        return view('usermanagement::role.index', $data);
    }

    public function addRole()
    {
        $data['title'] = 'Tambah Role';
        return view('usermanagement::role.add', $data);
    }
    
    public function addRoleStore(Request $request)
    {
        $credentials = $request->validate([
            'rolename'      => ['required', 'string'],
            'description'   => ['required', 'string'],
        ]);

        $create = Role::create([
            'uuid' => generateUuid(),
            'title' => $request->rolename,
            'slug' => sluggify($request->rolename),
            'description' => $request->description,
        ]);

        if ($create) {
            return back()->with('success', 'Role tersimpan!');
        }

        return back()->with('failed', 'Role gagal tersimpan!');        
    }

    public function permissionForm($role_uuid)
    {
        $data['title'] = 'Role Permission';
        $permissionList = Role::getMenu();
        foreach ($permissionList as $key => $value) {
            $access = Role::getAccess();
            $value->access = $access;
            foreach ($value->access as $keyAccess => $valueAccess) {
                $permission = Role::getPermission($value->slug, $valueAccess->name);
                $rolePermission = property_exists($permission, 'permid') ? Role::getRolePermission($permission->permid, $role_uuid) : false;
                $valueAccess->isAvailable = property_exists($permission, 'permid');
                $valueAccess->isGranted = $rolePermission;
            }
        }
        $data['permissionList'] = $permissionList;
        
        return view('usermanagement::role.permission', $data);
    }
}
