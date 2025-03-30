<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('asistentes_talleres', function (Blueprint $table) {
            $table->id('id_asistente');
            $table->foreignId('id_taller')->constrained('talleres', 'id_taller')->onDelete('cascade');
            $table->foreignId('id_medico')->nullable()->constrained('medicos', 'id_medico')->onDelete('set null');
            $table->string('nombre', 50)->nullable();
            $table->string('apellidos', 100)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('especialidad', 100)->nullable();
            $table->string('hospital', 100)->nullable();
            $table->boolean('asistio')->default(false);
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('asistentes_talleres');
    }
};
