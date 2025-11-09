@extends('layouts.app')

@section('content')
    <h1>Posts</h1>
    <form method="get" role="search" style="margin-bottom:1rem;">
        <input type="search" name="q" value="{{ $filters['q'] ?? '' }}" placeholder="Search title...">
        <button type="submit">Search</button>
        @if(($filters['q'] ?? null))
            <a href="{{ route('posts.index') }}">Reset</a>
        @endif
    </form>
    <a href="{{ route('posts.create') }}">+ New Post</a>
    <table>
        <thead><tr><th>Title</th><th>Published</th><th></th></tr></thead>
        <tbody>
        @forelse($posts as $post)
            <tr>
                <td><a href="{{ route('posts.show', $post->id) }}">{{ $post->title }}</a></td>
                <td>{{ $post->published_at ? \Carbon\Carbon::parse($post->published_at)->diffForHumans() : '—' }}</td>
                <td><a href="{{ route('posts.edit', $post->id) }}">Edit</a></td>
            </tr>
        @empty
            <tr><td colspan="3">No posts found.</td></tr>
        @endforelse
        </tbody>
    </table>
    {{ $posts->links() }}
@endsection
