<?php

namespace Modules\Almacen\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class InventarioController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Inventario index']);
    }

    // Additional methods can be added here as needed
}
