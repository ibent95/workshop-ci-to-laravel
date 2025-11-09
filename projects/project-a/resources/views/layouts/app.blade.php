<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Workshop') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@1/css/pico.min.css">
    <style>
        .container { max-width: 980px; margin: 2rem auto; }
        .flash { background:#d1fae5; padding:.75rem 1rem; border-radius:6px; margin-bottom:1rem; }
        nav a.active { font-weight:700; }
        textarea { min-height: 180px; }
    </style>
</head>
<body>
<nav class="container">
    <ul>
        <li><strong>{{ config('app.name') }}</strong></li>
    </ul>
    <ul>
        <li>
			<a
				href="{{ route('posts.index') }}"
				class="{{ request()->routeIs('posts.*') ? 'active' : '' }}"
			>Posts</a>
		</li>
        <li><a href="{{ route('posts.create') }}">Create</a></li>
    </ul>
</nav>
<main class="container">
    @if(session('status'))
        <div class="flash">{{ session('status') }}</div>
    @endif
    @yield('content')
</main>
</body>
</html>
