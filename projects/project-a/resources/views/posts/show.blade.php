@extends('layouts.app')

@section('content')
    <article>
        <header>
            <h1>{{ $post->title }}</h1>
            <p><small>Published: {{ $post->published_at?->toDayDateTimeString() ?? 'Draft' }}</small></p>
        </header>
        <p style="white-space:pre-line;">{{ $post->body }}</p>
    </article>
    <footer style="margin-top:1rem; display:flex; gap:.5rem;">
        <a href="{{ route('posts.edit', $post) }}">Edit</a>
        <form method="post" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Delete this post?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="secondary">Delete</button>
        </form>
        <a href="{{ route('posts.index') }}">Back</a>
    </footer>
@endsection
