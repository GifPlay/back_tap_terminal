<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;
use MongoDB\Laravel\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $collection = 'users';
    protected $connection = 'mongodb';

    protected $fillable = [
        'codigo',
        'usuario',
        'password',
        'nombre',
        'telefono',
        'fotoPerfil',
        'perfiles',
        'created_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($usuario) {
            $usuario->codigo = self::generarCodigoUnico();
            if ($usuario->password) {
                $usuario->password = Hash::make($usuario->password);
            }
            if (empty($usuario->fotoPerfil)) {
                $usuario->fotoPerfil = 'default.png';
            }
            if (empty($usuario->perfiles)) {
                $usuario->perfiles = [];
            }
        });
    }

    public static function generarCodigoUnico()
    {
        $ultimo = self::orderBy('_id', 'desc')->first();
        if (!$ultimo) {
            return 'U-0001';
        }

        $numero = intval(substr($ultimo->codigo, 2)) + 1;
        return 'U-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }
}
