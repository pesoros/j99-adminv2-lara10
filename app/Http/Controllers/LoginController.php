<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        if (Auth::check()) {
            return redirect()->intended('dashboard');
        }
        return view('auth.login');
    }
    
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);

        $validateAuth = Auth::attempt($credentials);
        echo $validateAuth;
        if ($validateAuth) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        };

        return back()->withErrors(['email']);
    }

    public function logout()
    {
        auth()->logout();
        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect('login')->with('message', 'Anda berhasil keluar');
    }
}
