<div>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="{{route('home')}}"><img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
                        </a>
                    </div>
                    <div class="hidden sm:ml-6 sm:block">
                        <div class="flex space-x-4">
                            <!-- Current: "bg-gray-900 text-white", Default: "text-gray-300 hover:bg-gray-700 hover:text-white" -->
                            <h1 class="text-gray-300 px-3 py-2" style="font-size:large;">Bienvenido</h1>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                            <!-- Profile dropdown -->
                            <div class="relative ml-3 " id="show-admin">
                                <div class="dropdown">
                                    <button class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium bg-gray-900" style="color: white;"><span class="material-symbols-outlined" style="margin: auto;">
                                    </span>Ver</button>
                                    <div class="dropdown-content">
                                        <a href="{{route('insurances')}}">Ver aseguradoras</a>
                                        <a href="{{route('specialties')}}">Ver especialidades</a>
                                        <a href="{{route('doctors')}}">Ver doctores</a>
                                        <a href="{{route('patients')}}">Ver pacientes</a>
                                        @if ($user->role_id == 1)
                                            <a href="{{route('users')}}">Ver usuarios</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">
                    <!-- Profile dropdown -->
                    <div class="relative ml-3 ">
                        <div class="dropdown">
                            <button class="text-gray-300 hover:bg-gray-700 hover:text-white rounded-md px-3 py-2 text-sm font-medium bg-gray-900" style="color: white;"><span class="material-symbols-outlined" style="margin: auto;">
                                    menu
                                </span></button>
                            <div class="dropdown-content">
                                <a href="{{route('logout')}}" id="logout-link">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
