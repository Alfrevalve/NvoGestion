@extends('layouts.sb-admin-pro')

@section('title', 'Resultados de Búsqueda - GesVitalPro')

@section('header-icon')
    <i class="fas fa-search"></i>
@endsection

@section('header-title', 'Resultados de Búsqueda')

@section('header-subtitle')
    Resultados para: "{{ request()->get('q', '') }}"
@endsection

@section('content')
    <div class="card mb-4">
        <div class="card-header">
            <form action="{{ route('search') }}" method="GET">
                <div class="input-group">
                    <input class="form-control" type="text" placeholder="Buscar..." name="q" value="{{ request()->get('q', '') }}" />
                    <button class="btn btn-primary" type="submit">Buscar</button>
                </div>
            </form>
        </div>
        <div class="card-body">
            @if(request()->has('q') && !empty(request()->get('q')))
                <h5 class="mb-4">Resultados para "{{ request()->get('q') }}"</h5>
                
                <!-- Resultados de búsqueda simulados -->
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3 bg-primary-soft text-primary"><i class="fas fa-procedures"></i></div>
                        <div>
                            <a href="#" class="text-dark mb-0 stretched-link text-decoration-none">
                                <h6 class="mb-0">Cirugía de Rodilla - Carlos Pérez</h6>
                            </a>
                            <div class="small text-muted">Cirugía | Dr. Torres | 25/03/2025</div>
                        </div>
                    </div>
                    <div class="ms-4">
                        <div class="badge bg-primary-soft text-primary rounded-pill">Cirugía</div>
                    </div>
                </div>
                <hr class="my-4" />
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3 bg-green-soft text-green"><i class="fas fa-user-md"></i></div>
                        <div>
                            <a href="#" class="text-dark mb-0 stretched-link text-decoration-none">
                                <h6 class="mb-0">Dr. Carlos Torres</h6>
                            </a>
                            <div class="small text-muted">Médico | Traumatología | 15 cirugías</div>
                        </div>
                    </div>
                    <div class="ms-4">
                        <div class="badge bg-green-soft text-green rounded-pill">Médico</div>
                    </div>
                </div>
                <hr class="my-4" />
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3 bg-yellow-soft text-yellow"><i class="fas fa-hospital"></i></div>
                        <div>
                            <a href="#" class="text-dark mb-0 stretched-link text-decoration-none">
                                <h6 class="mb-0">Hospital San Carlos</h6>
                            </a>
                            <div class="small text-muted">Institución | 25 cirugías programadas</div>
                        </div>
                    </div>
                    <div class="ms-4">
                        <div class="badge bg-yellow-soft text-yellow rounded-pill">Institución</div>
                    </div>
                </div>
                <hr class="my-4" />
                
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="d-flex align-items-center">
                        <div class="avatar avatar-lg me-3 bg-purple-soft text-purple"><i class="fas fa-toolbox"></i></div>
                        <div>
                            <a href="#" class="text-dark mb-0 stretched-link text-decoration-none">
                                <h6 class="mb-0">Kit de Instrumentación para Rodilla</h6>
                            </a>
                            <div class="small text-muted">Equipo | Disponible | 5 unidades</div>
                        </div>
                    </div>
                    <div class="ms-4">
                        <div class="badge bg-purple-soft text-purple rounded-pill">Equipo</div>
                    </div>
                </div>
                
                <!-- Paginación -->
                <nav class="mt-5">
                    <ul class="pagination justify-content-center">
                        <li class="page-item disabled">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">Anterior</a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">Siguiente</a>
                        </li>
                    </ul>
                </nav>
            @else
                <div class="text-center my-5">
                    <div class="display-6 text-primary mb-4"><i class="fas fa-search"></i></div>
                    <h3 class="text-dark">Busca en el sistema</h3>
                    <p class="text-muted">Ingresa un término de búsqueda para encontrar cirugías, médicos, instituciones, equipos y más.</p>
                </div>
            @endif
        </div>
    </div>
@endsection