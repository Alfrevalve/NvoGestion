<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('productos_cirugias', function (Blueprint $table) {
            $table->id('id_producto_cirugia');
            $table->foreignId('id_cirugia')->constrained('cirugias', 'id_cirugia')->onDelete('cascade');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->onDelete('cascade');
            $table->foreignId('id_lote')->nullable()->constrained('lotes_productos', 'id_lote')->onDelete('set null');
            $table->integer('cantidad');
            $table->decimal('precio_unitario', 10, 2)->nullable();
            $table->decimal('subtotal', 10, 2)->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos_cirugias');
    }
};
