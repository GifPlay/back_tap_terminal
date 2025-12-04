<?php

namespace App\Http\Controllers;

use App\Exports\UsuariosExport;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class UsuarioController extends Controller
{
    public function index()
    {
        return $usuarios = User::all();
    }

    public function show($id)
    {
        $usuario = User::find($id);
        if (!$usuario) {
            return response()->json([
                'message' => 'Usuario no encontrado'
            ], 404);
        }
        return response()->json($usuario, 200);
    }

    public function exportUsuariosPdf()
    {
        $usuarios = User::all();
        $pdf = Pdf::loadView('exporter.usuarios', compact('usuarios'));
        $pdf->setOptions(['isRemoteEnabled' => true]);
        return $pdf->download('usuarios.pdf');
    }

    public function exportUsuariosExcel()
    {
        return Excel::download(new UsuariosExport(), 'usuarios.xlsx');
    }

    public function uploadFoto(Request $request, $id)
    {
        $request->validate([
            'fotoPerfil' => 'required|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        $usuario = User::findOrFail($id);

        if ($request->hasFile('fotoPerfil')) {
            $file = $request->file('fotoPerfil');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('public/fotos', $filename);

            $usuario->fotoPerfil = $filename;
            $usuario->save();

            return response()->json([
                'message' => 'Foto subida correctamente',
                'fotoPerfil' => $filename
            ]);
        }

        return response()->json(['message' => 'No se subió ninguna imagen'], 400);
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
            'email' => $request->usuario,
            'nombre' => $request->nombre,
            'name' => $request->nombre,
            'telefono' => $request->telefono,
            'fotoPerfil' => $request->fotoPerfil,
            'password' => $request->password,
            'role' => $request->role,
            //'perfiles' => $request->perfiles ?? [],
        ]);
        return response()->json($usuario, 201);
    }

    public function update(Request $request, $id)
    {
        $validator = $this->validarUsuarioUpdate($request);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Errores de validación',
                'errors' => $validator->errors(),
            ], 205);
        }

        $usuarios = User::findOrFail($id);

        $usuarios->update($request->only([
            'codigo',
            'usuario',
            'email',
            'nombre',
            'telefono',
            'fotoPerfil',
            'role',
        ]));

        return $usuarios;
    }

    public function validarUsuarioUpdate(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            [
                'usuario' => 'required|email',
                'nombre' => 'required',
                'telefono' => [
                    'regex:/^\+[1-9]\d{1,3}\d{7,14}$/'
                ],
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
