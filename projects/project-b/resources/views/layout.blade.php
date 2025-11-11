<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
</head>
<body>
    <div style="padding:20px;">
        @auth
            <form action="/logout" method="POST">@csrf<button>Logout</button></form>
            <hr>
        @endauth

        @yield('content')
    </div>
</body>
</html>