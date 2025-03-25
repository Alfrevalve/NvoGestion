<?php

namespace Modules\Almacen\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MovimientoInventarioController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Movimiento Inventario index']);
    }

    // Additional methods can be added here as needed
}
