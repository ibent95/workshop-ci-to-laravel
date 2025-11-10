@extends('layout')

{{--@inject('commonService', \App\Services\CommonService::class);--}}
@php

Log::info('Test Force Log...');

$generated_id = common()->generateId();
$generated_uuid = common()->generateUuid();
$generated_uuid_v7 = common()->generateUuidV7();

@endphp

@Section('content')
<div>
    <!-- Let all your things have their places; let each part of your business have its time. - Benjamin Franklin -->
    <h1>Posts</h1>

    <ul>
        <li>Generated ID: {{ $generated_id }}</li>
        <li>Generated UUID: {{ $generated_uuid }}</li>
        <li>Generated UUID v7: {{ $generated_uuid_v7 }}</li>
    </ul>

    <a href="/posts/create" class="button">Create New Post</a>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Published At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($data as $post)
                <tr>
                    <td>{{ $post->title }}</td>
                    <td>{{ $post->content }}</td>
                    <td>{{ $post->published_at }}</td>
                    <td>
                        <a href="/posts/{{ $post->id }}/edit" class="button secondary">Edit</a>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="2">No posts found.</td>
                </tr>
            @endforelse
        </tbody>
</div>
@endsection