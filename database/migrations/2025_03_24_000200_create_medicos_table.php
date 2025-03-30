<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('medicos', function (Blueprint $table) {
            $table->id('id_medico');
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->string('especialidad', 100);
            $table->string('numero_colegiado', 50)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->string('codigo', 50)->unique();
            $table->string('hospital_principal', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->boolean('activo')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('medicos');
    }
};
