<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DoctorController extends Controller
{
    public function index()
    {
        $doctors = Doctor::join('specialties', 'doctors.specialty_id', '=', 'specialties.id')
        ->select('doctors.*', 'specialties.name as specialty_name')->get();

        return view('doctors', ['doctors' => $doctors, 'specialties' => Specialty::all(), 'user' => Auth::user()]);
    }

    public function add(Request $request)
    {
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

    public function update(Request $request, int $doctorId)
    {
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

    public function delete(int $userId)
    {
        $doctor = Doctor::find($userId);

        if ($doctor)
        {

            $doctor->delete();

            return redirect()->route('doctors')->with(
            [
                'status' => 'success',
                'message' => 'Doctor eliminado correctamente',
                'data' => $doctor
            ]);
            }
    }
}
