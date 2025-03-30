<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asignaciones_instrumentistas', function (Blueprint $table) {
            $table->id('id_asignacion');
            $table->foreignId('id_instrumentista')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_medico')->constrained('medicos', 'id_medico')->onDelete('cascade');
            $table->date('fecha_asignacion');
            $table->boolean('activo')->default(true);
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asignaciones_instrumentistas');
    }
};
