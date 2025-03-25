<?php

namespace Modules\Administracion\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ConfiguracionController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Configuracion data'], 200);
    }
}
