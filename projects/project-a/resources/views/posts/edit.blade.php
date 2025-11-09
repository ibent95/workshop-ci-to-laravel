@extends('layouts.app')

@section('content')
    <h1>Edit Post</h1>
    <form method="post" action="{{ route('posts.update', $post) }}">
        @method('PUT')
        @include('posts._form', ['post' => $post])
    </form>
@endsection
