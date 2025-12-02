<?php

namespace App\Models;

use MongoDB\Laravel\Eloquent\Model;

class Producto extends Model
{
    protected $collection = 'productos';
    protected $connection = 'mongodb';

    protected $fillable = [
        'codigo',
        'producto',
        'marca',
        'precio',
        'created_at',
        'updated_at',
    ];

    protected static function boot()
    {
        parent::boot();
        //Ingresa al ultimo registro creado y llama el metodo generarCodigoUnico, asignando el calor del codigo
        static::creating(function ($producto) {
            $producto->codigo = self::generarCodigoUnico();
        });
    }

    public static function generarCodigoUnico()
    {
        $year = date('Y');
        $prefijo = 'COD' . $year . '-';
        // Encontrar ultimo valor del año
        $ultimo = self::where('codigo', 'like', $prefijo . '%')
            ->orderBy('codigo', 'desc')
            ->first();

        if ($ultimo) {
            // Obtiene el numero consecutivo y suma 1
            $num = intval(substr($ultimo->codigo, -4)) + 1;
        } else {
            $num = 1;
        }

        // Agrega 4 ceros antes del numero consecutivo
        $codigo = $prefijo . str_pad($num, 4, '0', STR_PAD_LEFT);

        return $codigo;
    }
}
