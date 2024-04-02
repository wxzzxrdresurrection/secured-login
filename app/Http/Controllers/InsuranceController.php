<?php

namespace App\Http\Controllers;

use App\Models\Insurance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class InsuranceController extends Controller
{
    public function index()
    {
        return view('insurances', ['insurances' => Insurance::all(), 'user' => Auth::user()]);
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

        $insurance = Insurance::find($id);

        if ($insurance)
        {
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
    }

    public function delete(int $id)
    {
        $insurance = Insurance::find($id);

        if ($insurance)
        {
            $insurance->delete();

            return redirect()->route('insurances')->with([
                'status' => 'success',
                'message' => 'Compañía de seguros eliminada correctamente',
                'data' => $insurance
            ]);

        }
    }
}
