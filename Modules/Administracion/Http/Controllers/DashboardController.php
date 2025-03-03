<?php

namespace Modules\Administracion\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Display the administration dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('administracion::dashboard.index', [
            'title' => 'Panel de Administración',
            'breadcrumbs' => [
                ['name' => 'Inicio', 'url' => route('admin.dashboard')]
            ]
        ]);
    }
}
