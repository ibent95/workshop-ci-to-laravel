<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('profile')->get();
        $user = $users->first(); // contoh akses prole

        return view('admin.users.index', compact('users'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:profiles,email',
            'phone_number' => 'required',
            'username'     => 'required',
            'password'     => 'required|min:6',
            'role'         => 'required|in:admin,user'
        ]);

        $user = User::create([
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'username' => $request->username,
        ]);

        Profile::create([
            'user_id'         => $user->id,
            'name'            => $request->name,
            'email'           => $request->email,
            'phone_number'    => $request->phone_number,
        ]);

        return redirect()->route('users.index');
    }

    public function edit(User $user)
    {
        // Ambil profile terkait
        $profile = $user->profile;

        // Kirim keduanya ke view
        return view('admin.users.edit', compact('user', 'profile'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'         => 'required',
            'email'        => 'required|email|unique:profiles,email,' . $user->profile->id,
            'phone_number' => 'required',
            'username'     => 'required',
            'password'     => 'nullable',
            'role'         => 'required|in:admin,user'
        ]);

        $userData = [
            'username' => $request->username,
            'role'     => $request->role,
        ];

        if ($request->filled('password')) {
            $userData['password'] = Hash::make($request->password);
        }

        $user->update($userData);

        $user->profile->update([
            'name'            => $request->name,
            'email'           => $request->email,
            'phone_number'    => $request->phone_number,
        ]);

        return redirect()->route('users.index');
    }

    public function sendTestEmail(User $user)
    {
        $profile = $user->profile;

        SendUserNotification::dispatch(
            $profile,
            'Test Email',
            'This is a test email to verify the email configuration.'
        );

        return back()->with('success', 'Email uji coba telah dikirim!');
    }
}
