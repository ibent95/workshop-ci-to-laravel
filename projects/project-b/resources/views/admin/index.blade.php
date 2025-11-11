@extends('layout')

@section('content')
	<h1>Admin Dashboard</h1>
	<p>Selamat datang, {{ auth()->user()->profile->name }}</p>

@endsection