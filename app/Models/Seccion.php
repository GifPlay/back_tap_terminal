<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    protected $collection = 'secciones';
    protected $connection = 'mongodb';

    protected $fillable = [
        'codigo',
        'nombre', // Nombre de la sección, ej: productos, usuarios
        'descripcion',
        'created_at'
    ];
}
