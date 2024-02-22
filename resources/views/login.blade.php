<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
</head>
<body>
    <form action="{{route('login')}}" method="POST">
        @csrf
        <div class="form-frame">
            @error('login')
                <div class="alert-danger">{{ $message }}</div>
            @enderror
            @error('error')
                <div class="alert-danger">{{ $message }}</div>
            @enderror
                <div class="form-control">
                    <label for="email">Correo</label><br>
                    <input type="email" name="email" id="email" required>
                </div>
                <div class="form-control">
                    <label for="password">Contraseña</label><br>
                    <input type="password" name="password" id="password" required>
                </div>
                <button type="submit">Ingresar</button><br>
                <a href="{{route('registerView')}}"><button type="button">Registrarse</button></a>
            </div>
    </form>
</body>
</html>
