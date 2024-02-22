<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verificar Código</title>
</head>
<body>
    <form method="POST" id="form">
        @csrf
        <div class="form-frame">
            @error('login')
                <div class="alert-danger">{{ $message }}</div>
            @enderror
            @error('error')
                <div class="alert-danger">{{ $message }}</div>
            @enderror
                <p>Ingrese el código que recibirá por correo electrónico para verificar su identidad</p>
                <div class="form-control">
                    <label for="code">Código</label><br>
                    <input type="text" name="code" id="code" maxlength="6"  minlength="6" pattern="[0-9]+" required>
                </div>
                <button type="submit">Aceptar</button>
            </div>
    </form>
</body>
</html>

<script>

    var signedUrl = @json(session('url'));

    if(signedUrl != null && signedUrl != 'null' && signedUrl != '' && signedUrl != undefined){
        localStorage.setItem('signedUrl', signedUrl);
    }

    var form = document.getElementById('form');
    form.action = localStorage.getItem('signedUrl');

</script>
