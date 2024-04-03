<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use App\Models\Patient;
use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PatientController extends Controller
{
    public function index()
    {

        $patients = Patient::leftJoin('insurances', 'patients.insurance_id', '=', 'insurances.id')
            ->select('patients.id', 'patients.name', 'patients.last_name',"patients.gender",
            'patients.birth_date','patients.insurance_id', 'insurances.name as insurance_name')
            ->get();

        $insurances = Insurance::all();

        return view('patients',[
            'patients' => $patients,
            'insurances' => $insurances,
            'specialties' => Specialty::all(),
            'user' => Auth::user()
        ]);
    }



    public function add(Request $request)
    {
        $validate = Validator::make($request->all(),
        [
            'name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'insurance_id' => 'required|integer',
        ],
        [
            'insurance_id.required' => 'El campo :attribute es obligatorio',
            'insurance_id.integer' => 'El campo :attribute debe ser un número entero',
        ]);

        if ($validate->fails())
        {
            $errors = $validate->errors();
            return back()->withErrors($errors);
        }

        $patient = Patient::create([
            "name" => $request->name,
            "last_name" => $request->last_name,
            "birth_date" => $request->birth_date,
            "gender" => $request->gender,
            "insurance_id" => $request->insurance_id
        ]);

        return redirect()->route('patients')->with(
        [
            'status' => 'success',
            'message' => 'Paciente actualizado correctamente',
            'data' => $patient
        ]);
    }

    public function update(Request $request, int $patientId)
    {
        $validate = Validator::make($request->all(),
        [
            'name' => 'required',
            'last_name' => 'required',
            'birth_date' => 'required',
            'gender' => 'required',
            'insurance_id' => 'required|integer',
        ],
        [
            'insurance_id.required' => 'El campo :attribute es obligatorio',
            'insurance_id.integer' => 'El campo :attribute debe ser un número entero',
        ]);

        if ($validate->fails())
        {
            $errors = $validate->errors();
            return back()->withErrors($errors);
        }

        $patient = Patient::all()->find($patientId);

        if(!$patient)
        {
            return back();
        }

        $patient->update([
            "name" => $request->name,
            "last_name" => $request->last_name,
            "birth_date" => $request->birth_date,
            "gender" => $request->gender,
            "insurance_id" => $request->insurance_id
        ]);

        return redirect()->route('patients')->with(
        [
            'status' => 'success',
            'message' => 'Paciente actualizado correctamente',
            'data' => $patient
        ]);

    }

    public function delete(int $patientId)
    {
        $patient = Patient::find($patientId);

        if (!$patient)
        {
            return back();
        }

        $patient->delete();

        return redirect()->route('patients')->with(
        [
            'status' => 'success',
            'message' => 'Paciente eliminado correctamente',
            'data' => $patient
        ]);

    }

}
