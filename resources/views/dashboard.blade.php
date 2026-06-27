<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
</head>
<body>
    <h1>🎉 Welcome to Dashboard</h1>

    <p>
        Login sebagai:
        <strong>{{ Auth::user()->email }}</strong>
    </p>

    <form method="POST" action="/logout">
        @csrf
        <button type="submit">Logout</button>
    </form>
</body>
</html>
