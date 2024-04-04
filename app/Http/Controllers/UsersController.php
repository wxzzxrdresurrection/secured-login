<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\Role;
use App\Models\User;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class UsersController extends Controller
{
    public function index()
    {
        try {
            return view('users', ['users' => User::all(), 'roles' => Role::all()]);
        }
        catch(ValidationException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getValidationMessage()]);
        }
        catch(QueryException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getQueryMessage()]);
        }
        catch(PDOException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getPDOMessage()]);
        }
        catch(Exception $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getExceptionMessage()]);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(),
            [
                'name' => 'required|max:100|regex:/^[a-zA-ZáéíóúüñÁÉÍÓÚÜÑ\s]+$/',
                'email' => 'required|email',
                'phone' => 'required|numeric',
                'active' => 'required|boolean',
                'role_id' => 'required|numeric|exists:roles,id'
            ],
            [
                'name.required' => 'El campo :attribute es obligatorio',
                'name.string' => 'El campo :attribute debe ser una cadena de caracteres',
                'name.max' => 'El campo :attribute debe tener máximo 60 caracteres',
                'name.regex' => 'El campo :attribute debe contener solo letras',
                'email.required' => 'El campo :attribute es obligatorio',
                'email.email' => 'El campo :attribute debe ser un correo electrónico',
                'phone.required' => 'El campo :attribute es obligatorio',
                'phone.numeric' => 'El campo :attribute debe ser un número',
                'active.required' => 'El campo :attribute es obligatorio',
                'active.boolean' => 'El campo :attribute debe ser un valor booleano',
                'role_id.required' => 'El campo :attribute es obligatorio',
                'role_id.numeric' => 'El campo :attribute debe ser un número',
                'role_id.exists' => 'El campo :attribute no existe en la tabla roles'
            ]);

            if ($validate->fails())
            {
                $errors = $validate->errors();
                return back()->withErrors($errors);
            }

            $user = User::find($id);

            if (!$user)
            {
                return back()->withErrors(['error' => 'Usuario no encontrado']);
            }
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'active' => $request->active,
                'role_id' => $request->role_id,
            ]);

            if ($user->save())
            {
                return redirect()->route('users')->with(
                [
                    'status' => 'success',
                    'message' => 'Usuario actualizado correctamente',
                    'data' => $user
                ]);
            }
        }
        catch(ValidationException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getValidationMessage()]);
        }
        catch(QueryException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getQueryMessage()]);
        }
        catch(PDOException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getPDOMessage()]);
        }
        catch(Exception $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getExceptionMessage()]);
        }
    }

    public function delete($id)
    {
        try {
            $user = User::find($id);

            if (!$user)
            {
                return back()->withErrors(['error' => 'Usuario no encontrado']);
            }

            $user->delete();

            return redirect()->route('specialties')->with([
                'status' => 'success',
                'message' => 'Usuario eliminado correctamente',
                'data' => $user
            ]);
        }
        catch(ValidationException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getValidationMessage()]);
        }
        catch(QueryException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getQueryMessage()]);
        }
        catch(PDOException $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getPDOMessage()]);
        }
        catch(Exception $e)
        {
            Log::error($e->getMessage());
            return back()->withErrors(['error' => Constants::getExceptionMessage()]);
        }
    }
}
