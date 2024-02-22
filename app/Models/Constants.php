<?php

namespace App\Models;

const ADMIN_ROLE = 1;
const USER_ROLE = 2;

class Constants
{

    public static function getAdminRole()
    {
        return ADMIN_ROLE;
    }

    public static function getUserRole()
    {
        return USER_ROLE;
    }

    public static function getPDOMessage(){
        return "Error de conexión";
    }

    public static function getQueryMessage(){
        return "Error consultando la información";
    }

    public static function getValidationMessage(){
        return "Información inválida";
    }

    public static function getExceptionMessage(){
        return "Ocurrió un error inesperado";
    }
}
