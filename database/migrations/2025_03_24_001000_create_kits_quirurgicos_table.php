<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('kits_quirurgicos', function (Blueprint $table) {
            $table->id('id_kit');
            $table->string('nombre', 100);
            $table->text('descripcion')->nullable();
            $table->foreignId('id_tipo_cirugia')->nullable()->constrained('tipos_cirugias', 'id_tipo_cirugia')->onDelete('set null');
            $table->timestamps();
            $table->boolean('activo')->default(true);
        });
    }

    public function down()
    {
        Schema::dropIfExists('kits_quirurgicos');
    }
};
