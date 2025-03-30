<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('tipos_cirugias', function (Blueprint $table) {
            $table->id('id_tipo_cirugia');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->time('duracion_estimada')->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('tipos_cirugias');
    }
};
