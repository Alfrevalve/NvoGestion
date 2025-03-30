@extends('layouts.sb-admin-pro')

@section('title', 'Inventario')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-boxes"></i></div>
                        Inventario
                    </h1>
                </div>
                <div class="col-12 col-xl-auto mb-3">
                    <a class="btn btn-sm btn-primary" href="#">
                        <i class="fas fa-plus mr-1"></i>
                        Nuevo Artículo
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Total Artículos</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">345</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Valor Inventario</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">$215,000</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Categorías</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">12</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-tags fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Stock Bajo</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-exclamation-triangle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <i class="fas fa-table me-1"></i>
                    Artículos en Inventario
                </div>
                <div class="d-flex">
                    <div class="dropdown me-2">
                        <button class="btn btn-sm btn-light dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            Categoría
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a class="dropdown-item" href="#">Todas</a></li>
                            <li><a class="dropdown-item" href="#">Instrumental</a></li>
                            <li><a class="dropdown-item" href="#">Consumibles</a></li>
                            <li><a class="dropdown-item" href="#">Equipos</a></li>
                            <li><a class="dropdown-item" href="#">Implantes</a></li>
                        </ul>
                    </div>
                    <input type="text" class="form-control form-control-sm" placeholder="Buscar artículo...">
                </div>
            </div>
            <div class="card-body">
                <table id="datatablesSimple" class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Categoría</th>
                            <th>Stock</th>
                            <th>Precio</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Aquí se mostrarán los artículos -->
                        <tr>
                            <td>1</td>
                            <td>INS-001</td>
                            <td>Bisturí Quirúrgico</td>
                            <td>Instrumental</td>
                            <td>45</td>
                            <td>$120.00</td>
                            <td><span class="badge bg-success">Disponible</span></td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>2</td>
                            <td>CON-034</td>
                            <td>Gasas Estériles (paquete)</td>
                            <td>Consumibles</td>
                            <td>230</td>
                            <td>$15.50</td>
                            <td><span class="badge bg-success">Disponible</span></td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>3</td>
                            <td>IMP-098</td>
                            <td>Prótesis de Rodilla</td>
                            <td>Implantes</td>
                            <td>5</td>
                            <td>$3,500.00</td>
                            <td><span class="badge bg-warning">Stock Bajo</span></td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>4</td>
                            <td>EQU-012</td>
                            <td>Monitor de Signos Vitales</td>
                            <td>Equipos</td>
                            <td>8</td>
                            <td>$4,200.00</td>
                            <td><span class="badge bg-success">Disponible</span></td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                        <tr>
                            <td>5</td>
                            <td>CON-089</td>
                            <td>Guantes Quirúrgicos (caja)</td>
                            <td>Consumibles</td>
                            <td>12</td>
                            <td>$45.00</td>
                            <td><span class="badge bg-warning">Stock Bajo</span></td>
                            <td>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark me-2"><i class="fas fa-edit"></i></a>
                                <a href="#" class="btn btn-datatable btn-icon btn-transparent-dark"><i class="fas fa-trash"></i></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection