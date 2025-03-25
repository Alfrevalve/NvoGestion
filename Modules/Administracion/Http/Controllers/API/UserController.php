<?php

namespace Modules\Administracion\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'User data'], 200);
    }
}
