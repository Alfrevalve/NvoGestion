<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id('id_producto');
            $table->string('codigo', 50)->unique();
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->foreignId('id_categoria')->nullable()->constrained('categorias_productos', 'id_categoria')->onDelete('set null');
            $table->decimal('precio_compra', 10, 2)->nullable();
            $table->decimal('precio_venta', 10, 2)->nullable();
            $table->integer('stock_minimo')->default(0);
            $table->integer('stock_actual')->default(0);
            $table->string('ubicacion_almacen', 100)->nullable();
            $table->boolean('requiere_receta')->default(false);
            $table->boolean('es_esteril')->default(false);
            $table->date('fecha_caducidad')->nullable();
            $table->timestamps();
            $table->boolean('activo')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('productos');
    }
};
