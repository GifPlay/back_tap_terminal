<?php

namespace App\Http\Controllers;

use App\Models\Perfil;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PerfilController extends Controller
{
    public function index(){
        return $perfil = Perfil::all();
    }
    public function show($id)
    {
        $perfil = Perfil::find($id);
        if (!$perfil) {
            return response()->json([
                'message' => 'Perfil no encontrado'
            ], 204);
        }

        return response()->json($perfil);
    }

    public function store(Request $request){
        $validator = $this->validarPerfil($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 205);
        }

        $perfil = Perfil::create([
            'perfil' => $request->input('perfil'),
            'seccionesPermitidas' => $request->input('seccionesPermitidas'),
            'created_at' => now()
        ]);
        return response()->json($perfil, 201);
    }
    public function update(Request $request, $id)
    {
        $validator = $this->validarPerfil($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 205);
        }

        $perfil = Perfil::findOrFail($id);

        $perfil->update([
            'perfil'   => $request->perfil,
            'seccionesPermitidas'      => $request->seccionesPermitidas,
            'updated_at' => now(),
        ]);

        return $perfil;
    }

    public function validarPerfil(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'perfil' => 'required',
                'seccionesPermitidas' => 'required'
            ],
            [
                'perfil.required' => 'Debes ingresar el nombre del perfil.',
                'seccionesPermitidas.required'   => 'Las secciones son obligatorias.',
            ]
        );
        return $validator;
    }

    public function destroy($id)
    {
        $perfil = Perfil::findOrFail($id);

        if (!$perfil) {
            return response()->json([
                'message' => 'Perfil no encontrado, no es posible eliminarlo'
            ], 204);
        }

        $perfil->delete();

        return response()->json(['message' => 'Perfil eliminado']);
    }
}
