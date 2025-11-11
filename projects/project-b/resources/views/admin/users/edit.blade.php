@extends('layout')

@section('content')
	<h2>Profil Saya</h2>

	@if(session('success'))
		<p style="color:green;">{{ session('success') }}</p>
	@endif

	<form method="POST" action="{{ route('users.update', $user->id) }}">
		@csrf
		@method('PUT')
		Nama: <input type="text" name="name" value="{{ $user->profile->name }}"><br><br>
		Email: <input type="email" name="email" value="{{ $user->profile->email }}"><br><br>
		No. Handphone: <input type="tel" name="phone_number" value="{{ $user->profile->phone_number }}"><br><br>

		Otentikasi:
		Username: <input type="text" name="username" value="{{ $user->username }}"><br><br>
		Password: <input type="password" name="password" placeholder="Kosongkan jika tidak diubah"><br><br>
		Role:
		<select name="role">
			<option value="admin" {{ $user->role === 'admin' ? 'selected' : '' }}>Admin</option>
			<option value="user" {{ $user->role === 'user' ? 'selected' : '' }}>User</option>
		</select>

		<button>Update</button>
	</form>
@endsection