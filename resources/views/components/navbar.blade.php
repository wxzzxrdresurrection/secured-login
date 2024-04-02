<div>
    <nav class="bg-gray-800">
        <div class="mx-auto max-w-7xl px-2 sm:px-6 lg:px-8">
            <div class="relative flex h-16 items-center justify-between">
                <div class="flex flex-1 items-center justify-center sm:items-stretch sm:justify-start">
                    <div class="flex flex-shrink-0 items-center">
                        <a href="/home"><img class="h-8 w-auto" src="https://tailwindui.com/img/logos/mark.svg?color=indigo&shade=500" alt="Your Company">
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
                                <a href="/doctors">Ver doctores</a>
                                <a href="/patients">Ver pacientes</a>
                                @if ($user->role_id == 1)
                                    <a>Ver usuarios</a>
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
                                @if (!$user)
                                <a href="/signIn" id="login-link">Iniciar sesión</a>
                                <a href="/signUp" id="register-link">Registrarse</a>
                                @endif
                                <a href="/profile" id="profile-link">Mi perfil</a>
                                <a href="#" id="logout-link">Cerrar sesión</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</div>
{{-- <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script> --}}
{{-- <script>
    var isLogged = null, role_id = null, token = null;
    if (localStorage.getItem('isLogged') == null) {
        isLogged = false;
    } else {
        isLogged = localStorage.getItem('isLogged');
    }

    if (localStorage.getItem('role_id') == null) {
        role_id = null;
    } else {
        role_id = localStorage.getItem('role_id');
    }

    if (localStorage.getItem('auth_token') == null) {
        token = null;
    } else {
        token = localStorage.getItem('auth_token');
    }

    if (isLogged == 'true') {
        $('#logout-link').show();
        $('#profile-link').show();
        $('#login-link').hide();
        $('#register-link').hide();
        $('#getAppointment').show();
    } else {
        $('#logout-link').hide();
        $('#profile-link').hide();
        $('#login-link').show();
        $('#register-link').show();
        $('#getAppointment').hide();
    }

    if (role_id == 3) {
        $('#show-admin').show();
        $('#getAppointment').hide();
    } else if (role_id == 2) {
        $('#show-admin').hide();
        $('#getAppointment').hide();
    } else if (role_id == 1) {
        $('#show-admin').hide();
        $('#getAppointment').show();
    } else {
        $('#show-admin').hide();
        $('#getAppointment').hide();
    }

    $(document).ready(function() {
        $('#logout-link').click(function(e) {
            e.preventDefault();
            $.ajax({
                url: '/logout',
                method: 'GET',
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + token,
                },
                success: function(data) {
                    localStorage.removeItem('auth_token');
                    localStorage.removeItem('isLogged');
                    localStorage.removeItem('role_id');
                    window.location.href = '/';
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script> --}}
