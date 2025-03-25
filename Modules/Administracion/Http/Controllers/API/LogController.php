<?php

namespace Modules\Administracion\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class LogController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Log data'], 200);
    }
}
