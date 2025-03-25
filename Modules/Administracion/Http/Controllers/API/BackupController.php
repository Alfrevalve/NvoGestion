<?php

namespace Modules\Administracion\Http\Controllers\API;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BackupController extends Controller
{
    public function index()
    {
        return response()->json(['message' => 'Backup data'], 200);
    }
}
