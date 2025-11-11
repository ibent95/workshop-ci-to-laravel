<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function showLogin()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        // Cari profil berdasarkan email
        $user = User::with(['profile'])->where('username', $request->username)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'Username tidak ditemukan']);
        }

        $profile = $user->profile;

        if (!$profile || !Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'Password salah']);
        }

        // Login manual
        Auth::login($user);

        // Redirect berdasarkan role
        return ($user->role === 'admin')
            ? redirect('/users')
            : redirect('/profile');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/login');
    }
}
