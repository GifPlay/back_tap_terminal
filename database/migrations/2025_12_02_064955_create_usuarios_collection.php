<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Jenssegers\Mongodb\Schema\Blueprint;

return new class extends Migration {
    public function up() {
        Schema::connection('mongodb')->create('usuarios', function (Blueprint $collection) {
            $collection->string('codigo')->unique();
            $collection->string('usuario')->unique();
            $collection->string('password');
            $collection->string('nombre');
            $collection->string('telefono')->nullable();
            $collection->string('fotoPerfil')->nullable();
            $collection->array('perfiles')->default([]);
            $collection->timestamps();
        });
    }

    public function down() {
        Schema::connection('mongodb')->dropIfExists('usuarios');
    }
};
