<?php

namespace App\Http\Controllers;

use App\Models\Constants;
use App\Models\Doctor;
use App\Models\Specialty;
use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use PDOException;

class DoctorController extends Controller
{
    public function index()
    {
        try{

            $doctors = Doctor::join('specialties', 'doctors.specialty_id', '=', 'specialties.id')
                ->select('doctors.*', 'specialties.name as specialty_name')->orderBy('id', 'asc')->get();

            return view('doctors', ['doctors' => $doctors, 'specialties' => Specialty::all(), 'user' => Auth::user()]);

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

        try{
            $validate = Validator::make($request->all(),
            [
                'name' => 'required|string',
                'last_name' => 'required|string',
                'specialty_id' => 'required|integer'
            ],
            [
                'name.required' => 'El nombre es obligatorio',
                'name.string' => 'El nombre debe ser texto',
                'last_name.required' => 'El apellido es obligatorio',
                'last_name.string' => 'El apellido debe ser texto',
                'specialty_id.required' => 'El campo :attribute es obligatorio',
                'specialty_id.integer' => 'El campo :attribute debe ser un número entero'
            ]);

            if ($validate->fails())
            {
                $errors = $validate->errors();
                return back()->withErrors($errors);
            }

            $doctor = Doctor::create([
                "name" => $request->name,
                "last_name" => $request->last_name,
                "specialty_id" => $request->specialty_id
            ]);

            if($doctor->save())
            {
                    return redirect()->route('doctors')->with(
                    [
                        'status' => 'success',
                        'message' => 'Doctor agregado correctamente',
                        'data' => $doctor
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

    public function update(Request $request, int $doctorId)
    {

        try{
            $validate = Validator::make($request->all(),
            [
                'name' => 'required|string',
                'last_name' => 'required|string',
                'specialty_id' => 'required|integer'
            ],
            [
                'name.required' => 'El nombre es obligatorio',
                'name.string' => 'El nombre debe ser texto',
                'last_name.required' => 'El apellido es obligatorio',
                'last_name.string' => 'El apellido debe ser texto',
                'specialty_id.required' => 'El campo :attribute es obligatorio',
                'specialty_id.integer' => 'El campo :attribute debe ser un número entero'
            ]);

            if ($validate->fails())
            {
                $errors = $validate->errors();
                return back()->withErrors($errors);
            }

            $doctor = Doctor::find($doctorId);

            if(!$doctor)
            {
                return back();
            }

            $doctor->update([
                "name" => $request->name,
                "last_name" => $request->last_name,
                "specialty_id" => $request->specialty_id
            ]);

            return redirect()->route('doctors')->with(
            [
                'status' => 'success',
                'message' => 'Doctor agregado correctamente',
                'data' => $doctor
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

    public function delete(int $userId)
    {
        try{
            $doctor = Doctor::find($userId);

            if (!$doctor) {
                return redirect()->route('doctors')->with(
                [
                    'status' => 'error',
                    'message' => 'Doctor no encontrado',
                    'data' => null
                ]);
            }
            $doctor->delete();

            return redirect()->route('doctors')->with(
            [
                'status' => 'success',
                'message' => 'Doctor eliminado correctamente',
                'data' => $doctor
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
