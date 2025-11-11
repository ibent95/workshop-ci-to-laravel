@extends('layout')

@section('content')
	<h1>User Dashboard</h1>
	<p>Halo, {{ auth()->user()->profile->name }}</p>

	<h2>Daftar User</h2>
	<a href="{{ route('users.create') }}">Tambah User</a>

	<table border="1" cellpadding="6" cellspacing="0">
		<tr><th>Nama</th><th>Email</th><th>No. Handphone</th><th>Role</th><th>Aksi</th></tr>
		@foreach($users as $user)
			<tr>
				<td>{{ $user->profile->name }}</td>
				<td>{{ $user->profile->email }}</td>
				<td>{{ $user->profile->phone_number }}</td>
				<td>{{ $user->role }}</td>
				<td>
					<a href="{{ route('users.edit', $user) }}">Edit</a>
					<a href="{{ route('users.email.test', $user) }}">Kirim Email</a>
				</td>

			</tr>
		@endforeach
	</table>
@endsection