<?php

namespace Modules\Despacho\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VehiculoController extends Controller
{
    // Define your methods here
    public function index()
    {
        // Logic for listing vehiculos
    }

    public function create()
    {
        // Logic for showing the form to create a new vehiculo
    }

    public function store(Request $request)
    {
        // Logic for storing a new vehiculo
    }

    public function show($id)
    {
        // Logic for showing a specific vehiculo
    }

    public function edit($id)
    {
        // Logic for showing the form to edit an existing vehiculo
    }

    public function update(Request $request, $id)
    {
        // Logic for updating an existing vehiculo
    }

    public function destroy($id)
    {
        // Logic for deleting a vehiculo
    }
}
