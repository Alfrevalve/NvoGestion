<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsuariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id('id_usuario');
            $table->string('nombre', 50);
            $table->string('apellidos', 100);
            $table->string('email', 100)->unique();
            $table->string('password', 255);
            $table->enum('tipo_usuario', ['administrador', 'instrumentista', 'despachador', 'almacenista', 'vendedor']);
            $table->string('telefono', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->timestamps(0);
            $table->timestamp('fecha_creacion')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('remember_token')->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamp('last_seen_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('usuarios');
    }
}
