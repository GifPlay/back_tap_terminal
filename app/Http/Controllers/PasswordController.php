<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\PasswordReset;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;

class PasswordController extends Controller
{
    public function forgotPassword(Request $request)
    {
        $request->validate(['usuario' => 'required|email']);

        $user = User::where('usuario', $request->usuario)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $token = Str::random(60);

        PasswordReset::updateOrCreate(
            ['usuario' => $user->usuario],
            [
                'token' => $token,
                'created_at' => Carbon::now()
            ]
        );

        Mail::send('emails.reset', ['token' => $token, 'email' => $user->usuario], function ($message) use ($user) {
            $message->to($user->usuario);
            $message->subject('Recuperar contraseña');
        });

        return response()->json(['message' => 'Correo enviado']);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'token' => 'required',
            'password' => 'required|min:6|confirmed'
        ]);

        $reset = PasswordReset::where('email', $request->usuario)
            ->where('token', $request->token)
            ->first();

        if (!$reset) {
            return response()->json(['message' => 'Token inválido'], 400);
        }

        $user = User::where('email', $request->usuario)->first();
        if (!$user) {
            return response()->json(['message' => 'Usuario no encontrado'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        $reset->delete();

        return response()->json(['message' => 'Contraseña actualizada correctamente']);
    }
}
