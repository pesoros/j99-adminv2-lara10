<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserManController extends Controller
{
    public function account()
    {
        $data['title'] = 'Akun';
        $data ['list']= User::select('name','email')->get();

        return view('userman.account.index', $data);
    }

    public function addAccount()
    {
        $data['title'] = 'Tambah Akun';
        return view('userman.account.add', $data);
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
