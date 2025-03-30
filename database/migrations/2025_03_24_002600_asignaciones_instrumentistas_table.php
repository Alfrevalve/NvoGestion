<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::dropIfExists('asignaciones_instrumentistas');
    }

    public function down()
    {
        // This method can be left empty or you can recreate the table if needed.
    }
};
