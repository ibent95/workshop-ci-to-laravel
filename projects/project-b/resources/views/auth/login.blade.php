<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body style="max-width:400px;margin:50px auto;font-family:sans-serif;">
    <h2>Login</h2>

    @if ($errors->any())
        <div style="color:red;">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login.process') }}">
        @csrf

        <label>Username</label><br>
        <input type="text" name="username" value="{{ old('username') }}"><br><br>

        <label>Password</label><br>
        <input type="password" name="password"><br><br>

        <button type="submit">Login</button>
    </form>
</body>
</html>