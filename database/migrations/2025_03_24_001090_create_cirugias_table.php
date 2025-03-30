<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('cirugias', function (Blueprint $table) {
            $table->id('id_cirugia');
            $table->foreignId('id_medico')->constrained('medicos', 'id_medico')->onDelete('cascade');
            $table->foreignId('id_hospital')->constrained('hospitales', 'id_hospital')->onDelete('cascade');
            $table->foreignId('id_quirofano')->nullable()->constrained('quirofanos', 'id_quirofano')->onDelete('set null');
            $table->foreignId('id_tipo_cirugia')->nullable()->constrained('tipos_cirugias', 'id_tipo_cirugia')->onDelete('set null');
            $table->date('fecha_programada');
            $table->time('hora_inicio');
            $table->time('hora_fin')->nullable();
            $table->string('nombre_paciente', 150)->nullable();
            $table->string('tipo_documento_paciente', 20)->nullable();
            $table->string('documento_paciente', 20)->nullable();
            $table->enum('estado', ['programada', 'confirmada', 'en_proceso', 'finalizada', 'cancelada'])->default('programada');
            $table->text('observaciones')->nullable();
            $table->foreignId('id_instrumentista')->nullable()->constrained('usuarios', 'id_usuario')->onDelete('set null');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('cirugias');
    }
};
