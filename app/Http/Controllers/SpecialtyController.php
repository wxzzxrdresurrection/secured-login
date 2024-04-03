<?php

namespace App\Http\Controllers;

use App\Models\Specialty;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class SpecialtyController extends Controller
{
    public function index()
    {
        return view('specialties', ['specialties' => Specialty::all(), 'user' => Auth::user()]);
    }

    public function add(Request $request)
    {
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

    public function update(Request $request, int $id)
    {
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

        if ($specialty)
        {
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
    }

    public function delete(int $id)
    {
        $specialty = Specialty::find($id);

        if ($specialty)
        {
            $specialty->delete();

            return redirect()->route('specialties')->with([
                'status' => 'success',
                'message' => 'Especialidad eliminada correctamente',
                'data' => $specialty
            ]);

        }
    }
}
