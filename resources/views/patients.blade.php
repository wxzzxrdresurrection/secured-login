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
    @vite('resources/css/app.css')
    <title>Pacientes</title>
</head>
<body class="bg-sky-200">
    <x-navbar></x-navbar>
    <h1 class="text-center text-3xl my-4">Pacientes</h1>
    @if ($user->role_id != 3)
    <div class="flex justify-center; ml-[68%] mb-[1%]">
        <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800" data-bs-toggle="modal" data-bs-target="#exampleModal">
            <i class="bi bi-plus-circle-fill"></i>Agregar
        </button>
    </div>
    @endif
    <div class="flex justify-center">
        <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-white uppercase bg-gray-800 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="border px-6 py-3">Id</th>
                        <th scope="col" class="border px-6 py-3">Nombre</th>
                        <th scope="col" class="border px-6 py-3">Apellidos</th>
                        <th scope="col" class="border px-6 py-3">Género</th>
                        <th scope="col" class="border px-6 py-3">Fecha de nacimiento</th>
                        <th scope="col" class="border px-6 py-3">Aseguradora</th>
                        <th scope="col" class="border px-6 py-3">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($patients as $patient)
                    <tr class="bg-white">
                        <td class="border px-6 py-4">{{ $patient->id }} </td>
                        <td class="border px-6 py-4">{{ $patient->name }}</td>
                        <td class="border px-6 py-4">{{ $patient->last_name }}</td>
                        <td class="border px-6 py-4">{{ $patient->gender }}</td>
                        <td class="border px-6 py-4">{{ $patient->birth_date}}</td>
                        <td class="border px-6 py-4">{{ $patient->insurance_name }}</td>
                        @if ($user->role_id != 3)
                        <td class="border px-6 py-4">
                            <button class="bg-blue-500 rounded-sm px-2 text-white">
                                <i class="bi bi-pencil-square"
                                    data-bs-target="#modal-{{ $patient->id }}"
                                    data-bs-toggle="modal">
                                </i>
                            </button>
                            <a href="{{route('deletePatient', $patient->id)}}">
                                <button class="bg-red-500 rounded-sm px-2 text-white">
                                    <i class="bi bi-trash3-fill"></i></button>
                            </a>
                        </td>
                        @endif
                        <div class="modal fade" id="modal-{{ $patient->id }}"
                            tabindex="-1"
                            aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <form action="/updatePatient/{{ $patient->id }}" method="POST">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Paciente</h1>
                                            <button type="button" class="btn-close"
                                                data-bs-dismiss="modal"
                                                aria-label="Close">
                                            </button>
                                    </div>
                                    <div class="modal-body">
                                        @method('POST')
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label><br>
                                            <input name="name" value="{{$patient->name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mb-3">
                                            <label for="last_name" class="form-label">Apellido</label><br>
                                            <input name="last_name" value="{{$patient->last_name}}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mb-3">
                                            <label for="birth_date" class="form-label">Fecha de nacimiento</label><br>
                                            <input name="birth_date" value="{{$patient->birth_date}}" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        </div>
                                        <div class="mb-3">
                                            <label for="gender" class="form-label">Genero</label><br>
                                            <select name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="M">Masculino</option>
                                                <option value="F">Femenino</option>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="insurance_id" class="form-label">Aseguradora</label><br>
                                            <select name="insurance_id"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                @foreach ($insurances as $insurance )
                                                @php
                                                    $selected = $patient->insurance_id === $insurance->id
                                                    ? 'selected' : '' ;
                                                @endphp
                                                <option {{$selected}} value={{$insurance->id}}>
                                                    {{ $insurance->name }}</option>
                                                @endforeach
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
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <form action="{{route('addPatient')}}" method="POST">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h1 class="modal-title fs-5" id="exampleModalLabel">Nuevo Paciente</h1>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            @method('POST')
                            @csrf
                            <div class="mb-3">
                                <label for="name" class="form-label">Nombre</label>
                                <input required type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="name" name="name">
                            </div>
                            <div class="mb-3">
                                <label for="last_name" class="form-label">Apellido</label>
                                <input required type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="last_name" name="last_name">
                            </div>
                            <div class="mb-3">
                                <label for="birth_date" class="form-label">Fecha de nacimiento</label><br>
                                <input name="birth_date" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                            </div>
                            <div class="mb-3">
                                <label for="gender" class="form-label">Genero</label><br>
                                <select name="gender" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="M">Masculino</option>
                                    <option value="F">Femenino</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="insurance_id" class="form-label">Aseguradora</label>
                                <select required type="text"  class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" id="insurance_id" name="insurance_id">
                                    @foreach ($insurances as $insurance )
                                        <option value="{{$insurance->id}}">{{$insurance->name}}</option>
                                    @endforeach
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
    </div>
</body>
</html>
