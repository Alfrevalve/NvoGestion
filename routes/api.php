<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Aquí puedes definir las rutas de la API
Route::middleware('api')->get('/example', function (Request $request) {
    return response()->json(['message' => 'API is working!']);
});
