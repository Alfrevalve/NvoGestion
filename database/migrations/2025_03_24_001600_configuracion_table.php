<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('configuracion', function (Blueprint $table) {
            $table->id('id_configuracion');
            $table->string('nombre_empresa', 100);
            $table->string('ruc', 20)->nullable();
            $table->text('direccion')->nullable();
            $table->string('telefono', 20)->nullable();
            $table->string('email', 100)->nullable();
            $table->string('logo', 255)->nullable();
            $table->string('moneda', 10)->default('PEN');
            $table->decimal('impuesto_porcentaje', 5, 2)->default(18.00);
            $table->text('pie_pagina_factura')->nullable();
            $table->text('terminos_condiciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('configuracion');
    }
};
