<?php

namespace Modules\UserManagement\app\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    public function index()
    {
        $data['title'] = 'Akun';
        $data ['list']= User::select('name','email')->get();

        return view('usermanagement::index', $data);
    }

    public function addAccount()
    {
        $data['title'] = 'Tambah Akun';
        return view('usermanagement::add', $data);
    }
    
    public function addAccountStore(Request $request)
    {
        $credentials = $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required','email', 'unique:users,email'],
            'password' => ['required', 'min:8'],
        ]);

        $create = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        if ($create) {
            return back()->with('success', 'Akun tersimpan!');
        }

        return back()->with('success', 'Akun tersimpan!');        
    }
}
