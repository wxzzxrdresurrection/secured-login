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
    <form action="{{route('login')}}" method="POST" id="loginForm">
        @method('POST')
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
                    <div id="emailError" class="error-message"></div>
                </div>
                <div class="form-control">
                    <label for="password">Contraseña</label><br>
                    <input type="password" name="password" id="password" required maxlength="30" minlength="8">
                    <div id="passwordError" class="error-message"></div>
                </div>
                <button type="submit">Ingresar</button><br>
                <a href="{{route('registerView')}}"><button type="button">Registrarse</button></a>
            </div>
    </form>
</body>
</html>
<script>
    //Función para impedir que se envíe el formulario si no se cumplen las validaciones
    document.addEventListener('DOMContentLoaded', function() {
        var form = document.getElementById('loginForm');
        form.addEventListener('submit', function(event) {
           if(!validateForm()) {
               event.preventDefault();
           }
        });
    });

    //Función para validar el formulario y todos sus campos
    function validateForm() {
        var email = document.getElementById('email');
        var password = document.getElementById('password');

        var emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,4}$/;
        var passwordRegex = /^(?=.*[A-Z])(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_+])[A-Za-z\d!@#$%^&*()_+]{8,}$/;

        clearErrors('emailError');
        clearErrors('passwordError');
        
        if(!emailRegex.test(email.value)) {
            addErrorToField('emailError', 'El correo electrónico no es válido');
            return false;
        }


        if(!passwordRegex.test(password.value)) {
            addErrorToField('passwordError', 'La contraseña debe tener al menos 8 caracteres, una mayúscula, una minúscula, un número y un caracter especial (!@#$%^&*()-+)');
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