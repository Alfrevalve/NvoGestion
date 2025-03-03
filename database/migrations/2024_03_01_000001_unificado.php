<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabla para categorías (para inventarios)
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique()->comment('Nombre de la categoría');
            $table->string('descripcion')->nullable()->comment('Descripción de la categoría');
            $table->timestamps();
        });

        // 2. Tabla para proveedores
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del proveedor');
            $table->string('contacto')->nullable()->comment('Contacto principal');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->string('direccion')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 3. Tabla para instituciones
        Schema::create('instituciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre de la institución');
            $table->string('direccion')->nullable();
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 4. Tabla para médicos
        Schema::create('medicos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del médico');
            $table->string('especialidad')->nullable()->comment('Especialidad del médico');
            $table->string('matricula')->unique()->comment('Matrícula profesional');
            $table->string('telefono')->nullable();
            $table->string('email')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 5. Tabla para instrumentistas
        Schema::create('instrumentistas', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del instrumentista');
            $table->string('telefono')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 6. Tabla para equipos
        Schema::create('equipos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del equipo');
            $table->string('codigo')->unique()->comment('Código único del equipo');
            $table->text('descripcion')->nullable();
            $table->string('numero_serie')->nullable()->comment('Número de serie');
            $table->date('fecha_adquisicion')->nullable();
            $table->date('fecha_mantenimiento')->nullable();
            $table->enum('estado', ['disponible', 'en uso', 'mantenimiento', 'fuera de servicio'])
                  ->default('disponible')->comment('Estado actual del equipo');
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 7. Tabla para materiales
        Schema::create('materiales', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->comment('Nombre del material');
            $table->text('descripcion')->nullable();
            $table->string('codigo')->unique()->comment('Código único del material');
            $table->integer('cantidad')->default(0)->comment('Cantidad en stock');
            $table->integer('cantidad_minima')->default(0)->comment('Cantidad mínima requerida');
            $table->string('ubicacion')->nullable();
            $table->string('proveedor')->nullable();
            $table->text('notas')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Índices para optimización
            $table->index('nombre');
            $table->index('codigo');
            $table->index('cantidad');
        });

        // 8. Tabla para inventarios (versión mejorada)
        Schema::create('inventarios', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique()->comment('Código único del producto');
            $table->string('nombre')->comment('Nombre del producto');
            $table->text('descripcion')->nullable();
            $table->integer('cantidad')->default(0)->comment('Cantidad en stock');
            $table->decimal('precio_unitario', 10, 2)->default(0.00)->comment('Precio unitario');
            $table->integer('stock_minimo')->default(0)->comment('Stock mínimo permitido');
            $table->integer('stock_maximo')->nullable()->comment('Stock máximo permitido');
            $table->enum('estado', ['disponible', 'agotado', 'stock_bajo', 'reservado'])
                  ->default('disponible')->comment('Estado actual del producto');
            $table->string('ubicacion')->nullable()->comment('Ubicación en el almacén');
            $table->string('tipo')->nullable()->comment('Tipo o categoría general del producto');
            $table->foreignId('categoria_id')
                  ->nullable()
                  ->constrained('categorias')
                  ->onDelete('set null')
                  ->comment('Categoría del producto');
            $table->foreignId('proveedor_id')
                  ->nullable()
                  ->constrained('proveedores')
                  ->onDelete('set null')
                  ->comment('Proveedor del producto');
            $table->timestamp('fecha_ultima_entrada')->nullable()->comment('Fecha de la última entrada');
            $table->timestamp('fecha_ultima_salida')->nullable()->comment('Fecha de la última salida');
            $table->timestamps();
            $table->softDeletes();

            // Índices para optimización
            $table->index('nombre');
            $table->index('estado');
        });

        // 9. Tabla para cirugías
        Schema::create('cirugias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('institucion_id')->constrained('instituciones')->onDelete('restrict');
            $table->foreignId('medico_id')->constrained('medicos')->onDelete('restrict');
            $table->foreignId('instrumentista_id')->constrained('instrumentistas')->onDelete('restrict');
            $table->foreignId('equipo_id')->constrained('equipos')->onDelete('restrict');
            $table->date('fecha')->comment('Fecha de la cirugía');
            $table->time('hora')->comment('Hora de la cirugía');
            $table->string('tipo_cirugia')->comment('Tipo de cirugía');
            $table->enum('estado', ['pendiente', 'programada', 'en proceso', 'finalizada', 'cancelada'])
                  ->default('pendiente')->comment('Estado de la cirugía');
            $table->enum('prioridad', ['baja', 'media', 'alta', 'urgente'])
                  ->default('media')->comment('Prioridad de la cirugía');
            $table->integer('duracion_estimada')->nullable()->comment('Duración estimada en minutos');
            $table->text('observaciones')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // 10. Tabla pivote para la relación muchos a muchos entre cirugías y materiales
        Schema::create('cirugia_material', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cirugia_id')->constrained('cirugias')->onDelete('cascade');
            $table->foreignId('material_id')->constrained('materiales')->onDelete('restrict');
            $table->integer('cantidad_usada')->default(1)->comment('Cantidad de material usado');
            $table->timestamps();
        });

        // 11. Tabla para reportes de cirugías
        Schema::create('reportes_cirugias', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cirugia_id')->constrained('cirugias')->onDelete('cascade');
            $table->string('sistema', 255)->comment('Sistema donde se registró el reporte');
            $table->enum('hoja_consumo', ['Si', 'No'])->comment('Indica si se usó hoja de consumo');
            $table->text('observaciones')->nullable();
            $table->timestamps();
        });

        // 12. Tabla para movimientos de inventario
        Schema::create('movimientos_inventario', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventario_id')->constrained('inventarios')->onDelete('cascade');
            $table->enum('tipo', ['entrada', 'salida'])->comment('Tipo de movimiento');
            $table->integer('cantidad')->comment('Cantidad movida');
            $table->decimal('precio_unitario', 10, 2)->comment('Precio unitario aplicado en el movimiento');
            $table->string('referencia')->nullable()->comment('Referencia o número de documento');
            $table->text('observaciones')->nullable()->comment('Observaciones adicionales');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            $table->index('tipo');
        });

        // Agregar restricciones CHECK para evitar valores negativos (si el SGBD lo soporta y no es SQLite)
        if (DB::getDriverName() !== 'sqlite') {
            DB::statement('ALTER TABLE inventarios ADD CONSTRAINT check_cantidad_no_negativa CHECK (cantidad >= 0)');
            DB::statement('ALTER TABLE inventarios ADD CONSTRAINT check_stock_minimo_no_negativo CHECK (stock_minimo >= 0)');
            DB::statement('ALTER TABLE movimientos_inventario ADD CONSTRAINT check_movimiento_cantidad_no_negativa CHECK (cantidad >= 0)');
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('movimientos_inventario');
        Schema::dropIfExists('reportes_cirugias');
        Schema::dropIfExists('cirugia_material');
        Schema::dropIfExists('cirugias');
        Schema::dropIfExists('inventarios');
        Schema::dropIfExists('materiales');
        Schema::dropIfExists('equipos');
        Schema::dropIfExists('instrumentistas');
        Schema::dropIfExists('medicos');
        Schema::dropIfExists('instituciones');
        Schema::dropIfExists('proveedores');
        Schema::dropIfExists('categorias');
    }
};
