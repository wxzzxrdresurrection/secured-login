<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Registro</title>
        <link rel="stylesheet" type="text/css" href="{{ asset('css/app.css') }}">
        <script src="https://www.google.com/recaptcha/api.js?hl=es-419" async defer></script>
    </head>
    <body>
    <form action="{{route('register')}}" method="POST" id="registerForm">
        @method('POST')
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
                    <input type="text" name="name" id="name" placeholder="Tu nombre" required minlength="3">
                    <div id="nameError" class="error-message"></div>
                </div>
                <div class="form-control">
                    <label for="phone">Telefono</label><br>
                    <input type="tel" name="phone" id="phone" placeholder="Tu telefono" minlength="10" maxlength="10" required>
                    <div id="phoneError" class="error-message"></div>
                </div>
                <div class="form-control">
                    <label for="email">Correo</label><br>
                    <input type="email" name="email" id="email" placeholder="nombre@example.com" required>
                    <div id="emailError" class="error-message"></div>
                </div>
                <div class="form-control">
                    <label for="password">Contraseña</label><br>
                    <input type="password" name="password" id="password" required maxlength="30" minlength="8">
                    <div id="passwordError" class="error-message"></div>
                </div>
                <div class="form-control">
                    <label for="password_confirmation">Confirmar contraseña</label><br>
                    <input type="password" name="password_confirmation" id="password_confirmation" required maxlength="30" minlength="8">
                    <div id="passwordConfirmationError" class="error-message"></div>
                </div>
                <div class="form-captcha">
                    <div class="g-recaptcha" data-sitekey="{{ $siteKey }}"></div>
                    <br/>
                    @error('captcha')
                        <div class="error-message">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit">Registrar</button>
                <a href="{{route('loginView')}}"><button type="button">Iniciar Sesión</button></a>
            </div>
    </form>
    </body>
</html>
<script>
    //Función para impedir que se envíe el formulario si no se cumplen las validaciones
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('registerForm');
        form.addEventListener('submit', function(event) {
           if(!validateForm()) {
               event.preventDefault();
           }
        });
    });

    //Función para validar el formulario y todos sus campos
    function validateForm() {
        var name = document.getElementById('name');
        var email = document.getElementById('email');
        var phone_number = document.getElementById('phone');
        var password = document.getElementById('password');
        var password_confirmation = document.getElementById('password_confirmation');

        var nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚüÜñÑ\s]+$/;
        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        var phoneRegex = /^[0-9]+$/;
        var passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;

        clearErrors('nameError');
        clearErrors('emailError');
        clearErrors('phoneError');
        clearErrors('passwordError');
        clearErrors('passwordConfirmationError');

        if(!nameRegex.test(name.value)) {
            addErrorToField('nameError', 'El nombre no acepta números ni caracteres especiales');
            return false;
        }

        if(!phoneRegex.test(phone_number.value)) {
            addErrorToField('phoneError', 'El número de teléfono no es válido');
            return false;
        }

        if(!emailRegex.test(email.value)) {
            addErrorToField('emailError', 'El correo electrónico no es válido');
            return false;
        }


        if(!passwordRegex.test(password.value)) {
            addErrorToField('passwordError', 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un caracter especial (!@#$%^&*()-+)');
            return false;
        }

        if(password.value !== password_confirmation.value) {
            addErrorToField('passwordConfirmationError', 'Las contraseñas no coinciden');
            return false;
        }

        return true;
    }

    //Función para agregar un mensaje de error a un campo
    function addErrorToField(fieldId, message) {
        var fieldError = document.getElementById(fieldId);
        fieldError.textContent = message;
    }
    
    //Función para limpiar los mensajes de error de un campo y que no se muestren repetidos
    function clearErrors(fieldId) {
        var fieldError = document.getElementById(fieldId);
        fieldError.textContent = '';
    }
</script>