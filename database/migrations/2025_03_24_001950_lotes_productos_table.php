<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('lotes_productos', function (Blueprint $table) {
            $table->id('id_lote');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->onDelete('cascade');
            $table->string('numero_lote', 50);
            $table->date('fecha_fabricacion')->nullable();
            $table->date('fecha_caducidad')->nullable();
            $table->integer('cantidad');
            $table->date('fecha_entrada');
            $table->string('proveedor', 100)->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('lotes_productos');
    }
};
