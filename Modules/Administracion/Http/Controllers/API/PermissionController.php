<?php

namespace Modules\Administracion\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PermissionController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Permission data'], 200);
    }
}
