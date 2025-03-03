<?php

namespace Modules\Cirugias\Http\Controllers;

use Illuminate\Http\Request;
use Modules\Cirugias\Models\Cirugia;

class TestCirugia
{
    public function create()
    {
        $data = [
            'fecha' => '2023-10-01',
            'hora' => '10:00',
            'estado' => 'Pendiente',
            'observaciones' => 'Observaciones de prueba',
        ];

        Cirugia::create($data);
        return 'Cirugía creada con éxito.';
    }
}

$test = new TestCirugia();
echo $test->create();
