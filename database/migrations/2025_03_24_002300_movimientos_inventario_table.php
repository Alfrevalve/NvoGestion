<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id('id_movimiento');
            $table->foreignId('id_producto')->constrained('productos', 'id_producto')->onDelete('cascade');
            $table->foreignId('id_lote')->nullable()->constrained('lotes_productos', 'id_lote')->onDelete('set null');
            $table->enum('tipo_movimiento', ['entrada', 'salida', 'ajuste', 'devolucion']);
            $table->integer('cantidad');
            $table->timestamp('fecha_movimiento')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->foreignId('id_usuario')->constrained('usuarios', 'id_usuario')->onDelete('cascade');
            $table->foreignId('id_cirugia')->nullable()->constrained('cirugias', 'id_cirugia')->onDelete('set null');
            $table->foreignId('id_taller')->nullable()->constrained('talleres', 'id_taller')->onDelete('set null');
            $table->foreignId('id_compra')->nullable()->constrained('compras', 'id_compra')->onDelete('set null');
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('movimientos_inventario');
    }
};
