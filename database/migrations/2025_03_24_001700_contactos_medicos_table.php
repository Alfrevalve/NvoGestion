<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('contactos_medicos', function (Blueprint $table) {
            $table->id('id_contacto');
            $table->foreignId('id_medico')->constrained('medicos', 'id_medico')->onDelete('cascade');
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->dateTime('fecha_contacto');
            $table->enum('tipo_contacto', ['llamada', 'visita', 'email', 'whatsapp', 'otro']);
            $table->text('motivo')->nullable();
            $table->text('resultado')->nullable();
            $table->boolean('seguimiento_requerido')->default(false);
            $table->date('fecha_seguimiento')->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('contactos_medicos');
    }
};
