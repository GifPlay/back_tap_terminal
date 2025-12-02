<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Perfil extends Model
{
    protected $table = 'perfiles';
    protected $connection = 'mongodb';

    protected $fillable = [
        'codigo',
        'perfil',
        'seccionesPermitidas',
        'created_at',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($perfil) {
            $perfil->codigo = self::generarCodigoUnico();
        });
    }

    public static function generarCodigoUnico()
    {
        $ultimo = self::orderBy('_id', 'desc')->first();
        if (!$ultimo) {
            return 'P-0001';
        }

        $numero = intval(substr($ultimo->codigo, 2)) + 1;
        return 'P-' . str_pad($numero, 4, '0', STR_PAD_LEFT);
    }
}
