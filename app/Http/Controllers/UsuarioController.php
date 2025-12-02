<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UsuarioController extends Controller
{
    public function index()
    {
        return $usuarios = User::all();
    }

    public function show($id)
    {
        $usuarios = User::find($id);
        if (!$usuarios) {
            return response()->json([
                'message' => 'Producto no encontrado'
            ], 204);
        }

        return response()->json($usuarios);
    }

    public function store(Request $request)
    {
        $validator = $this->validarUsuario($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 205);
        }

        $usuario = User::create([
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'fotoPerfil' => $request->fotoPerfil,
            'password' => $request->password,
            'perfiles' => $request->perfiles ?? [],
        ]);
        return response()->json($usuario, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validarUsuario($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 205);
        }

        $usuarios = User::findOrFail($id);

        $usuarios->update([
            'codigo' => $request->codigo,
            'usuario' => $request->usuario,
            'nombre' => $request->nombre,
            'telefono' => $request->telefono,
            'fotoPerfil' => $request->fotoPerfil,
            //'password'     => $request->perfiles,
            'updated_at' => now(),
        ]);

        return $usuarios;
    }

    public function validarUsuario(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'usuario' => 'required|email|unique:users,usuario',
                'nombre' => 'required',
                'password' => 'required',
                'telefono' => [
                    'regex:/^\+[1-9]\d{1,3}\d{7,14}$/'
                ],
                /*'fotoPerfil' => [
                    'required',
                    'regex:/^data:image\/(jpg|jpeg|png|gif);base64,/',
                ]*/
            ],
            [
                'usuario.required' => 'El usuario es obligatorio.',
                'usuario.unique' => 'El usuario debe ser unico.',
                'password.required' => 'La contraseña es obligatorio.',
                'nombre.required' => 'El nombre es obligatorio.',
                'telefono.regex' => 'El teléfono no contiene el código de pais.',
                'fotoPerfil.required' => 'La foto de perfil es obligatoria.',
            ]
        );
        return $validator;
    }

    public function destroy($id)
    {
        $producto = User::findOrFail($id);

        if (!$producto) {
            return response()->json([
                'message' => 'Usuario no encontrado, no es posible eliminarlo'
            ], 204);
        }

        $producto->delete();

        return response()->json(['message' => 'Producto eliminado']);
    }
}
