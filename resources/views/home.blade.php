<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Home</title>
</head>
<body>
    @if ($role ==  1 )
    Vista de administrador
    @endif
    @if ($role ==  2 )
    Vista de usuario
    @endif
    <a href="{{route('logout')}}"><button>Logout</button></a>
</body>
</html>
