<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <title>Enlace inválido</title>
</head>
<body>
    <div class="form-frame">
        <div class="form-content">
            <h1>Enlace inválido</h1>
            <p>El enlace que has seguido no es válido o ha caducado.</p>
            <p>Si crees que se trata de un error, por favor, ponte en contacto con nosotros.</p>
            <a href="{{ route('registerView') }}" class="btn btn-primary">Volver a la página principal</a>
        </div>
    </div>
</body>
</html>
