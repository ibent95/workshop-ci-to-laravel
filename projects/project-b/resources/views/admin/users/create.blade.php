@extends('layout')

@section('content')
	<h2>Tambah User</h2>

	<form method="POST" action="{{ route('users.store') }}">
		@csrf
		Nama: <input type="text" name="name"><br><br>
		Email: <input type="email" name="email"><br><br>
		No. Handphone: <input type="tel" name="phone_number"><br><br>
		Username: <input type="text" name="username"><br><br>
		Password: <input type="password" name="password"><br><br>
		Role:
		<select name="role">
			<option value="user">User</option>
			<option value="admin">Admin</option>
		</select><br><br>
		<button>Simpan</button>
	</form>
@endsection