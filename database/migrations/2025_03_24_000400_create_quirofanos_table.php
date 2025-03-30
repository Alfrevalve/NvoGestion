<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('quirofanos', function (Blueprint $table) {
            $table->id('id_quirofano');
            $table->foreignId('id_hospital')->constrained('hospitales', 'id_hospital')->onDelete('cascade');
            $table->string('nombre', 50);
            $table->string('piso', 20)->nullable();
            $table->text('observaciones')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('quirofanos');
    }
};
