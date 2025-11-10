@extends('layout')

@section('content')
<form action="/posts" method="POST">
    @csrf
    @method('PUT')
    <h1>Edit Post</h1>
    <input type="hidden" name="id" value="{{ $data->id }}">

    <label for="title">Title</label>
    <input type="text" id="title" name="title" value="{{ $data->title }}" required>

    <label for="content">Content</label>
    <textarea id="content" name="content" required>{{ $data->content }}</textarea>

    <label for="published_at">Publish At</label>
    <input type="datetime-local" id="published_at" value="{{ $data->published_at }}" name="published_at">

    <button type="submit" class="button primary">Submit</button>
</form>
@endsection

