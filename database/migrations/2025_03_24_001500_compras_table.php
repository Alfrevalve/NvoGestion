<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('compras', function (Blueprint $table) {
            $table->id('id_compra');
            $table->foreignId('id_proveedor')->constrained('proveedores', 'id_proveedor')->onDelete('cascade');
            $table->string('numero_factura', 50)->nullable();
            $table->date('fecha_compra');
            $table->decimal('total', 10, 2);
            $table->enum('estado', ['pendiente', 'recibida', 'pagada', 'cancelada'])->default('pendiente');
            $table->date('fecha_recepcion')->nullable();
            $table->foreignId('id_usuario_receptor')->nullable()->constrained('usuarios', 'id_usuario')->onDelete('set null');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('compras');
    }
};
