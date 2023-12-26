<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Role;

class AccountController extends Controller
{
    public function listAccount()
    {
        $data['title'] = 'Akun';
        $data['list'] = User::getUserList();

        return view('usermanagement::account.index', $data);
    }

    public function addAccount()
    {
        $data['title'] = 'Tambah Akun';
        $data['roles'] = Role::getRole();
        return view('usermanagement::account.add', $data);
    }
    
    public function addAccountStore(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required','email', 'unique:v2_users,email'],
            'password' => ['required', 'min:8'],
            'role' => ['required', 'string'],
        ]);

        $create = User::create([
            'uuid' => generateUuid(),
            'name' => $request->name,
            'email' => $request->email,
            'role_uuid' => $request->role,
            'password' => Hash::make($request->password),
        ]);

        if ($create) {
            return back()->with('success', 'Akun tersimpan!');
        }

        return back()->with('failed', 'Akun gagal tersimpan!');        
    }

    public function editAccount($uuid)
    {
        $data['title'] = 'Edit Account';
        $data['user'] = User::getUser($uuid);
        $data['roles'] = Role::getRole();

        return view('usermanagement::account.edit', $data);
    }

    public function editAccountUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            // 'password' => ['required', 'min:8'],
            'role' => ['required', 'string'],
        ]);
        
        $updateData = [
            'name' => $request->name,
            'email' => $request->email,
            // 'password' => $request->password,
            'role_uuid' => $request->role,
        ];
        
        $updateUser = User::updateUser($uuid, $updateData);

        if ($updateUser) {
            return back()->with('success', 'Akun berhasil diubah!');
        }

        return back()->with('failed', 'Akun gagal diubah!');   
    }

    public function editAccountPassword($uuid)
    {
        $data['user'] = User::getUser($uuid);
        $data['title'] = 'Edit Account Password';


        return view('usermanagement::account.password', $data);
    }

    public function editAccountPasswordUpdate(Request $request, $uuid)
    {
        $credentials = $request->validate([
            'password' => ['required', 'min:8'],
        ]);
        
        $updateData = [
            'password' => Hash::make($request->password),
        ];
        
        $updateUser = User::updateUser($uuid, $updateData);

        if ($updateUser) {
            return back()->with('success', 'Akun Password berhasil diubah!');
        }

        return back()->with('failed', 'Akun Password gagal diubah!');   
    }

    public function deleteAccount($uuid)
    {
        $delete = User::removeUser($uuid);

        if ($delete) {
            return back()->with('success', 'Akun berhasil terhapus!');
        }

        return back()->with('failed', 'Akun gagal terhapus!');
    }
}
