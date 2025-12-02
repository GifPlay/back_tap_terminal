<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use MongoDB\Laravel\Schema\Blueprint;

return new class extends Migration
{
    public function up()
    {
        Schema::connection('mongodb')->create('productos', function (Blueprint $collection) {
            $collection->string('codigo')->unique();
            $collection->string('producto');
            $collection->string('marca');
            $collection->integer('precio');
            $collection->timestamps();
        });
    }

    public function down()
    {
        Schema::connection('mongodb')->dropIfExists('productos');
    }
};
