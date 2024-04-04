<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    @vite(['resources/css/app.css','resources/js/app.js'])
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <title>Home</title>
</head>
<x-navbar/>
<body class="bg-sky-200">
    @if ($user->role_id ==  1 )
    <h1 class="text-center mt-5">Panel de administrador</h1>
    @elseif ($user->role_id == 2)
    <h1 class="text-center mt-5">Panel de coordinador</h1>
    @elseif ($user->role_id == 3)
    <h1 class="text-center mt-5">Panel de usuario</h1>
    @endif
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-center">Informacion del usuario</h3>
                    </div>
                    <div class="card-body text-center">
                        <p><strong>Nombre:</strong> {{$user->name}}</p>
                        <p><strong>Telefono:</strong> {{$user->phone}}</p>
                        <p><strong>Email:</strong> {{$user->email}}</p>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
