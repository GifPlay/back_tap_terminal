<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class Usuario extends Model
{
    protected $collection = 'usuarios';
    protected $connection = 'mongodb';

    protected $fillable = [
        'codigo',
        'usuario',
        'pass',
        'nombre',
        'telefono',
        'fotoPerfil',
        'perfiles',
        'api_token',
        'reset_token',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($usuario) {
            $usuario->codigo = self::generarCodigoUnico();
            if ($usuario->password) {
                $usuario->password = Hash::make($usuario->password);
            }
        });
    }

    public static function generarCodigoUnico()
    {
        $ultimo = self::orderBy('codigo', 'desc')->first();
        $num = $ultimo ? intval(substr($ultimo->codigo, 2)) + 1 : 1;
        return 'U-' . str_pad($num, 4, '0', STR_PAD_LEFT);
    }

    public function checkPassword($password)
    {
        return Hash::check($password, $this->password);
    }
}
