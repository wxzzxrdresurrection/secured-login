<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <script src="https://www.google.com/recaptcha/api.js?hl=es-419" async defer></script>
    </head>
    <body>
    <form action="{{route('register')}}" method="POST">
        @csrf
        <div class="form-frame">
            @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('phone')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('email')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('password')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('error')
                <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="form-control">
                    <label for="name">Nombre</label><br>
                    <input type="text" name="name" id="name" placeholder="Tu nombre" required>
                </div>
                <div class="form-control">
                    <label for="phone">Telefono</label><br>
                    <input type="tel" name="phone" id="phone" placeholder="Tu telefono" pattern="[0-9]{10}" minlength="10" maxlength="10" required>
                </div>
                <div class="form-control">
                    <label for="email">Correo</label><br>
                    <input type="email" name="email" id="email" placeholder="nombre@example.com" required>
                </div>
                <div class="form-control">
                    <label for="password">Contraseña</label><br>
                    <input type="password" name="password" id="password" required>
                </div>
                <div class="form-control">
                    <label for="password_confirmation">Confirmar contraseña</label><br>
                    <input type="password" name="password_confirmation" id="password_confirmation" required>
                </div>
                <div class="form-captcha">
                    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
                    <br/>
                    <input type="submit" value="Registrar">
                </div>
                <a href="{{route('loginView')}}"><button type="button">Iniciar Sesión</button></a>
            </div>
    </form>
    </body>
</html>
