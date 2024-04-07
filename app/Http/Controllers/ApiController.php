<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class ApiController extends Controller
{

    public function login(Request $request)
    {
        try{
            #Validar informacion del request
            $validator = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required|min:8',
            ],
            [
                'email.required' => 'El correo es obligatorio',
                'email.email' => ' El correo debe ser un correo electrónico válido',
                'password.required' => 'El contraseña es obligatorio',
                'password.min' => ' La contraseña debe tener al menos 8 caracteres',
            ]);

            #Regresar si hay errores
            if ($validator->fails()) {
                return response()->json([
                        'error' => $validator->errors(),
                        'success' => false
                    ], 401);
            }

            #Validar credenciales
            $user = User::where('email', $request->email)->first();

            if (!$user || !Hash::check($request->password, $user->password)){
                return response()->json([
                    'message' => 'Invalid login details',
                    'success' => false
                ], 401);
            }

            #Regresar si el usuario no esta activo
            if(!$user->active || $user->role_id != Constants::getAdminRole()){
                return response()->json([
                    'message' => 'Access Denied',
                    'success' => false
                ], 401);
            }

            return response()->json([
                'message' => 'Logged in',
                'user' => $user,
                'token' => $user->createToken('token')->plainTextToken,
                'success' => true
            ], 200);
        }
        catch(ValidationException $e){
            return response()->json([
                'message' => Constants::getValidationMessage(),
                'success' => false
            ], 500);
        }
        catch(QueryException $e){
            return response()->json([
                'message' => Constants::getQueryMessage(),
                'success' => false
            ], 500);
        }
        catch(PDOException){
            return response()->json([
                'message' => Constants::getPDOMessage(),
                'success' => false
            ], 500);
        }
        catch(Exception $e){
            return response()->json([
                'message' => Constants::getExceptionMessage(),
                'success' => false
            ], 500);
        }
    }

    public function apiLogout(Request $request)
    {
        try {
            #Eliminar tokens del usuario
            $request->user()->tokens()->delete();

            return response()->json([
                'message' => 'Logged out',
                'success' => true
            ]);
        }
        catch(ValidationException $e){
            return response()->json([
                'message' => Constants::getValidationMessage(),
                'success' => false
            ], 500);
        }
        catch(QueryException $e){
            return response()->json([
                'message' => Constants::getQueryMessage(),
                'success' => false
            ], 500);
        }
        catch(PDOException){
            return response()->json([
                'message' => Constants::getPDOMessage(),
                'success' => false
            ], 500);
        }
        catch(Exception $e){
            return response()->json([
                'message' => Constants::getExceptionMessage(),
                'success' => false
            ], 500);
        }
    }

    public function verifyCode(Request $request)
    {
        try{
            #Validar informacion del request
            $validator = Validator::make($request->all(), [
                'code' => 'required|digits:6',
            ],
            [
                'code.required' => 'El código es obligatorio',
                'code.numeric' => 'El código debe ser un número',
                'code.digits' => 'El código debe tener 6 dígitos',
            ]);

            #Regresar si hay errores
            if ($validator->fails()) {
                return response()->json([
                        'error' => $validator->errors()
                    ], 401);
            }

            #Verificar código
            $user = $request->user();

            if(($user->role_id == Constants::getAdminRole() && $request->ip() != '10.8.20.29')
            || ($user->role_id == Constants::getUserRole() && $request->ip() == '10.8.20.29')){
                return response()->json([
                    'message' => 'Access Denied',
                    'success' => false
                ], 401);
            }

            $code = rand(100000, 999999);
            $user->code = Hash::make($code);
            $user->save();

            #Regresar segund código
            if(Hash::check($request->code, $user->extra_code)){
                return response()->json([
                    'message' => 'Valid code',
                    'code' => $code,
                    'success' => true
                ], 200);
            }

            #Regresar si el código no es válido
            return response()->json([
                'message' => 'Invalid code',
                'success' => false
            ], 401);

        }
        catch(ValidationException $e){
            return response()->json([
                'message' => Constants::getValidationMessage(),
                'success' => false
            ], 500);
        }
        catch(QueryException $e){
            return response()->json([
                'message' => Constants::getQueryMessage(),
                'success' => false
            ], 500);
        }
        catch(PDOException){
            return response()->json([
                'message' => Constants::getPDOMessage(),
                'success' => false
            ], 500);
        }
        catch(Exception $e){
            return response()->json([
                'message' => Constants::getExceptionMessage(),
                'success' => false
            ], 500);
        }
    }
}
