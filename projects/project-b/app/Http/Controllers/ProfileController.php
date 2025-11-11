<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $profile = $user->profile; // relasi: User hasOne Profile

        return view('user.profile', compact('user', 'profile'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255',
            'phone_number' => 'nullable|string|max:20',
        ]);

        $user = auth()->user();
        $user->update([
            'username' => $request->username,
        ]);

        $user->profile->update([
            'phone_number' => $request->phone_number,
        ]);

        return back()->with('success', 'Profile berhasil diperbarui!');
    }
}
