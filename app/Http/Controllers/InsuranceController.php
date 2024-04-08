<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\Insurance;
use Dotenv\Exception\ValidationException;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use PDOException;

class InsuranceController extends Controller
{
    public function index()
    {
        try
        {
            $insurances = Insurance::orderBy('id', 'asc')->get();
            return view('insurances', ['insurances' => $insurances, 'user' => Auth::user()]);
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

            $insurance = Insurance::create([
                'name' => $request->name
            ]);

            if ($insurance->save())
            {
                return redirect()->route('insurances')->with(
                [
                    'status' => 'success',
                    'message' => 'Compañía de seguros agregada correctamente',
                    'data' => $insurance
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

            $insurance = Insurance::find($id);

            if (!$insurance){
               return back()->withErrors(['error' => 'Compañía de seguros no encontrada']);
            }
            $insurance->name = $request->name;

            if ($insurance->save())
            {
                return redirect()->route('insurances')->with(
                [
                    'status' => 'success',
                    'message' => 'Compañía de seguros actualizada correctamente',
                    'data' => $insurance
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
            $insurance = Insurance::find($id);

            if (!$insurance) {
                return back()->withErrors(['error' => "Compañía de seguros no encontrada"]);
            }
            $insurance->delete();

            return redirect()->route('insurances')->with([
                'status' => 'success',
                'message' => 'Compañía de seguros eliminada correctamente',
                'data' => $insurance
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
