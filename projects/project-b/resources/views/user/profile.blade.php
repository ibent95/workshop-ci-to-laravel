@extends('layout')

@section('content')
<div class="container" style="max-width: 600px;">
    <h2>Profile</h2>

    @if(session('success'))
        <div style="padding: 8px; background: #d1ffd1; margin-bottom: 12px;">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div style="margin-bottom: 12px;">
            <label>Username</label>
            <input type="text" name="username" value="{{ old('username', $user->username) }}" style="width: 100%;">
            @error('username') <small style="color:red">{{ $message }}</small> @enderror
        </div>

        <div style="margin-bottom: 12px;">
            <label>Phone Number</label>
            <input type="text" name="phone_number" value="{{ old('phone_number', $profile->phone_number) }}" style="width: 100%;">
        </div>

        <button type="submit">Update Profile</button>
    </form>
</div>
@endsection