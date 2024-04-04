<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\Specialty;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class SpecialtyController extends Controller
{

    public function index()
    {
        try{
            return view('specialties', ['specialties' => Specialty::all(), 'user' => Auth::user()]);
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

    public function add(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),
            [
                'name' => 'required|string|max:80'
            ],
            [
                'name.required' => 'El campo :attribute es obligatorio',
                'name.string' => 'El campo :attribute debe ser una cadena de caracteres',
                'name.max' => 'El campo :attribute debe tener máximo 60 caracteres'
            ]);

            if ($validate->fails())
            {
                $errors = $validate->errors();
                return back()->withErrors($errors);
            }

            $specialty = Specialty::create([
                'name' => $request->name
            ]);

            if ($specialty->save())
            {
                return redirect()->route('specialties')->with(
                [
                    'status' => 'success',
                    'message' => 'Especialidad agregada correctamente',
                    'data' => $specialty
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

    public function update(Request $request, int $id)
    {
       try {
            $validate = Validator::make($request->all(),
            [
                'name' => 'required|string|max:80'
            ],
            [
                'name.required' => 'El campo :attribute es obligatorio',
                'name.string' => 'El campo :attribute debe ser una cadena de caracteres',
                'name.max' => 'El campo :attribute debe tener máximo 60 caracteres'
            ]);

            if ($validate->fails())
            {
                $errors = $validate->errors();
                return back()->withErrors($errors);
            }

            $specialty = Specialty::find($id);

            if (!$specialty)
            {
                return back()->withErrors(['error' => 'Especialidad no encontrada']);
            }
            $specialty->name = $request->name;

            if ($specialty->save())
            {
                return redirect()->route('specialties')->with(
                [
                    'status' => 'success',
                    'message' => 'Especialidad actualizada correctamente',
                    'data' => $specialty
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

    public function delete(int $id)
    {
        try {
            $specialty = Specialty::find($id);

            if (!$specialty)
            {
                return back()->withHeaders(['error' => 'Especialidad no encontrada']);
            }

            $specialty->delete();

            return redirect()->route('specialties')->with([
                'status' => 'success',
                'message' => 'Especialidad eliminada correctamente',
                'data' => $specialty
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
