<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('talleres', function (Blueprint $table) {
            $table->id('id_taller');
            $table->string('titulo', 150);
            $table->text('descripcion')->nullable();
            $table->dateTime('fecha_inicio');
            $table->dateTime('fecha_fin');
            $table->string('lugar', 100)->nullable();
            $table->foreignId('id_hospital')->nullable()->constrained('hospitales', 'id_hospital')->onDelete('set null');
            $table->integer('capacidad_maxima')->nullable();
            $table->foreignId('responsable_id')->nullable()->constrained('usuarios', 'id_usuario')->onDelete('set null');
            $table->enum('estado', ['planificado', 'confirmado', 'en_curso', 'finalizado', 'cancelado'])->default('planificado');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('talleres');
    }
};
