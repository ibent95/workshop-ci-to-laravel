@extends('layout')

@section('content')
<form action="/posts" method="POST">
    @csrf
    <h1>Create New Post</h1>
    <label for="title">Title</label>
    <input type="text" id="title" name="title" required>

    <label for="content">Content</label>
    <textarea id="content" name="content" required></textarea>

    <label for="published_at">Publish At</label>
    <input type="datetime-local" id="published_at" name="published_at">

    <button type="submit" class="button primary">Submit</button>
</form>
@endsection

