<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('instituciones', function (Blueprint $table) {
            $table->id('id_institucion');
            $table->string('nombre', 100);
            $table->string('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->boolean('activo')->default(true);
            $table->timestamps();
            $table->string('ubicacion')->nullable();
            $table->string('tipo', 50)->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('instituciones');
    }
};
