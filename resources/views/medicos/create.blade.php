@extends('layouts.sb-admin-pro')

@section('title', 'Nuevo Médico')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-user-md"></i></div>
                        Nuevo Médico
                    </h1>
                </div>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header">
                <i class="fas fa-user-plus me-1"></i>
                Formulario de Registro
            </div>
            <div class="card-body">
                <form method="POST" action="#" class="needs-validation" novalidate>
                    @csrf
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="nombre" class="form-label">Nombre</label>
                            <input type="text" class="form-control" id="nombre" name="nombre" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el nombre.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" required>
                            <div class="invalid-feedback">
                                Por favor ingrese los apellidos.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label for="tipo_documento" class="form-label">Tipo de Documento</label>
                            <select class="form-select" id="tipo_documento" name="tipo_documento" required>
                                <option value="">Seleccione...</option>
                                <option value="DNI">DNI</option>
                                <option value="Pasaporte">Pasaporte</option>
                                <option value="Carnet de Extranjería">Carnet de Extranjería</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione un tipo de documento.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="documento" class="form-label">Número de Documento</label>
                            <input type="text" class="form-control" id="documento" name="documento" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el número de documento.
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="colegiatura" class="form-label">Número de Colegiatura</label>
                            <input type="text" class="form-control" id="colegiatura" name="colegiatura" required>
                            <div class="invalid-feedback">
                                Por favor ingrese el número de colegiatura.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="especialidad" class="form-label">Especialidad</label>
                            <select class="form-select" id="especialidad" name="especialidad" required>
                                <option value="">Seleccione...</option>
                                <option value="Traumatología">Traumatología</option>
                                <option value="Neurocirugía">Neurocirugía</option>
                                <option value="Cirugía General">Cirugía General</option>
                                <option value="Cirugía Cardiovascular">Cirugía Cardiovascular</option>
                                <option value="Cirugía Plástica">Cirugía Plástica</option>
                                <option value="Oftalmología">Oftalmología</option>
                                <option value="Otorrinolaringología">Otorrinolaringología</option>
                                <option value="Urología">Urología</option>
                                <option value="Ginecología">Ginecología</option>
                            </select>
                            <div class="invalid-feedback">
                                Por favor seleccione una especialidad.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="tel" class="form-control" id="telefono" name="telefono" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un teléfono de contacto.
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                            <div class="invalid-feedback">
                                Por favor ingrese un email válido.
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <input type="text" class="form-control" id="direccion" name="direccion">
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="biografia" class="form-label">Biografía/Experiencia</label>
                        <textarea class="form-control" id="biografia" name="biografia" rows="3"></textarea>
                    </div>
                    <div class="d-flex justify-content-end">
                        <a href="{{ route('medicos.index') }}" class="btn btn-outline-secondary me-2">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar Médico</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
    // Example starter JavaScript for disabling form submissions if there are invalid fields
    (function () {
        'use strict'

        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var forms = document.querySelectorAll('.needs-validation')

        // Loop over them and prevent submission
        Array.prototype.slice.call(forms)
            .forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault()
                        event.stopPropagation()
                    }

                    form.classList.add('was-validated')
                }, false)
            })
    })()
</script>
@endsection