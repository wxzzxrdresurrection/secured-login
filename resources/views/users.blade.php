<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    @vite(['resources/css/app.css','resources/js/app.js'])
    <title>Usuarios</title>
</head>

<body class="bg-sky-200">
    <x-navbar />
    <h1 class="text-center text-3xl mt-4">Usuarios</h1>
    @if (session('status'))
    <div class="flex justify-center rounded-md">
        <div class="text-center bg-white px-32 shadow-md">
            {{ session('message') }}
        </div>
    </div>
    @endif

    @if ($errors->any())
    <div class="flex justify-center rounded-md">
        <div class="text-center bg-white px-32 shadow-md">
            <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="relative overflow-x-auto shadow-md sm:rounded-lg" style="width:60%; margin:auto;">
        <table class="w-full text-sm rtl:text-right text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-white uppercase bg-gray-800 dark:bg-gray-700 dark:text-gray-400">
                <tr style="text-align: center;">
                    <th class="border py-3">Id</th>
                    <th class="border py-3">Nombre</th>
                    <th class="border py-3">Correo</th>
                    <th class="border py-3">Telefono</th>
                    <th class="border py-3">Rol</th>
                    <th class="border py-3">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                <tr class="border border-collapse bg-white text-center">
                    <td class="border px-6 py-2">{{ $user->id }}</td>
                    <td class="border px-6 py-2">{{ $user->name }}</td>
                    <td class="border px-6 py-2">{{ $user->email }}</td>
                    <td class="border px-6 py-2">{{ $user->phone }}</td>
                    <td class="border px-6 py-2">{{ $user->role->name }}</td>
                    <td class="border px-6 py-2">
                        <button class="bg-blue-500 rounded-sm px-2 text-white">
                            <i class="bi bi-pencil-square" data-bs-target="#modal-{{ $user->id }}" data-bs-toggle="modal"></i></button>
                        @if ($user->id != auth()->user()->id)
                        <a href="{{route('deleteUser', $user->id)}}">
                            <button class="bg-red-500 rounded-sm px-2 text-white">
                                <i class="bi bi-trash3-fill"></i></button>
                            </a>
                        @endif
                    </td>
                </tr>
                <div class="modal fade" id="modal-{{ $user->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <form action="/updateUser/{{ $user->id }}" method="POST">
                        @method('POST')
                        @csrf
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Editar Usuario</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre</label>
                                        <input type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="name" value="{{ $user->name }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Correo</label>
                                        <input type="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="email" value="{{ $user->email }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Telefono</label>
                                        <input type="tel" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="phone" value="{{ $user->phone }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="role" class="form-label">Rol</label>
                                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="role_id" id="role_id">
                                            @foreach ($roles as $role)
                                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone" class="form-label">Estado</label>
                                        <select class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" name="active" id="active">
                                            <option value="1">Activo</option>
                                            <option value="0">Inactivo</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" data-bs-dismiss="modal">Cancelar</button>
                                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Guardar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                @endforeach
            </tbody>
        </table>
        {{-- <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="/add" method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nueva Especialidad</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @method('POST')
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input required type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="name" name="name">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700" data-bs-dismiss="modal">Cancelar</button>
                            <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">Guardar</button>
                        </div>
                    </div>
                </div>
            </form>
        </div> --}}
    </div>
</body>

</html>
