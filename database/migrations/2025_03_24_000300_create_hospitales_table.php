<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('hospitales', function (Blueprint $table) {
            $table->id('id_hospital');
            $table->string('nombre', 100);
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('persona_contacto', 100)->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->boolean('activo')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('hospitales');
    }
};
