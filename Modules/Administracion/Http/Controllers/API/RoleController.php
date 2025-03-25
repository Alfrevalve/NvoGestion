<?php

namespace Modules\Administracion\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class RoleController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Role data'], 200);
    }
}
