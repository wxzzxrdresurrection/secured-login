<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body style="background-color: white">
    @if ($role ==  1 )
    <h1>Vista de administrador</h1>
    @endif
    @if ($role ==  2 )
    <h1>Vista de usuario</h1>
    @endif
    <a href="{{route('logout')}}"><button>Logout</button></a>
</body>
</html>
