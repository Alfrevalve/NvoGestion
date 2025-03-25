<?php

namespace Modules\Almacen\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Categoria index']);
    }

    // Additional methods can be added here as needed
}
