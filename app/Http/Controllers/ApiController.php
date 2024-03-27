<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ApiController extends Controller
{

    public function login(Request $request)
    {
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

    public function apiLogout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logged out',
            'success' => true
        ]);
    }

    public function verifyCode(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'code' => 'required|digits:6',
        ],
        [
            'code.required' => 'El código es obligatorio',
            'code.numeric' => 'El código debe ser un número',
            'code.digits' => 'El código debe tener 6 dígitos',
        ]);

        if ($validator->fails()) {
            return response()->json([
                    'error' => $validator->errors()
                ], 401);
        }

        $user = $request->user();
        $code = rand(100000, 999999);
        $user->code = Hash::make($code);
        $user->save();

        if(Hash::check($request->code, $user->extra_code)){
            return response()->json([
                'message' => 'Valid code',
                'code' => $code,
                'success' => true
            ], 200);
        }

        return response()->json([
            'message' => 'Invalid code',
            'success' => false
        ], 401);
    }

}
