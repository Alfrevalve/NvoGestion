<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstrumentistasTable extends Migration
{
    public function up()
    {
        Schema::create('instrumentistas', function (Blueprint $table) {
            $table->id('id_instrumentista');
            $table->string('nombre');
            $table->string('telefono')->nullable();
            $table->string('email')->unique()->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instrumentistas');
    }
}
