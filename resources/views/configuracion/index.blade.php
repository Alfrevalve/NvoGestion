@extends('layouts.sb-admin-pro')

@section('title', 'Configuración del Sistema')

@section('content')
    <div class="container-fluid px-4">
        <div class="page-header-content">
            <div class="row align-items-center justify-content-between pt-3">
                <div class="col-auto mb-3">
                    <h1 class="page-header-title">
                        <div class="page-header-icon"><i class="fas fa-cog"></i></div>
                        Configuración del Sistema
                    </h1>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-4">
                <div class="nav nav-pills flex-column nav-pills-light" id="configTab" role="tablist">
                    <a class="nav-link active" id="general-tab" data-bs-toggle="pill" href="#general" role="tab" aria-controls="general" aria-selected="true">
                        <i class="fas fa-sliders-h me-2"></i> General
                    </a>
                    <a class="nav-link" id="email-tab" data-bs-toggle="pill" href="#email" role="tab" aria-controls="email" aria-selected="false">
                        <i class="fas fa-envelope me-2"></i> Configuración de Email
                    </a>
                    <a class="nav-link" id="backup-tab" data-bs-toggle="pill" href="#backup" role="tab" aria-controls="backup" aria-selected="false">
                        <i class="fas fa-database me-2"></i> Copias de Seguridad
                    </a>
                    <a class="nav-link" id="notifications-tab" data-bs-toggle="pill" href="#notifications" role="tab" aria-controls="notifications" aria-selected="false">
                        <i class="fas fa-bell me-2"></i> Notificaciones
                    </a>
                    <a class="nav-link" id="logs-tab" data-bs-toggle="pill" href="#logs" role="tab" aria-controls="logs" aria-selected="false">
                        <i class="fas fa-list me-2"></i> Registros del Sistema
                    </a>
                </div>
            </div>
            <div class="col-lg-8">
                <div class="tab-content" id="configTabContent">
                    <!-- Configuración General -->
                    <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-sliders-h me-1"></i>
                                Configuración General
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="siteName" class="form-label">Nombre del Sitio</label>
                                        <input type="text" class="form-control" id="siteName" value="NvoGestion - Sistema de Gestión de Cirugías">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="timezone" class="form-label">Zona Horaria</label>
                                            <select class="form-select" id="timezone">
                                                <option value="America/Lima" selected>América/Lima (UTC-5)</option>
                                                <option value="America/Bogota">América/Bogotá (UTC-5)</option>
                                                <option value="America/Mexico_City">América/Ciudad de México (UTC-6)</option>
                                                <option value="America/Santiago">América/Santiago (UTC-4)</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="dateFormat" class="form-label">Formato de Fecha</label>
                                            <select class="form-select" id="dateFormat">
                                                <option value="d/m/Y" selected>DD/MM/AAAA</option>
                                                <option value="m/d/Y">MM/DD/AAAA</option>
                                                <option value="Y-m-d">AAAA-MM-DD</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="maintenanceMode" class="form-check-label">Modo Mantenimiento</label>
                                        <div class="form-check form-switch mt-2">
                                            <input class="form-check-input" type="checkbox" id="maintenanceMode">
                                            <label class="form-check-label" for="maintenanceMode">Activar modo mantenimiento</label>
                                        </div>
                                        <div class="form-text">Cuando está activado, solo los administradores pueden acceder al sistema.</div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="siteLogo" class="form-label">Logo del Sitio</label>
                                        <input class="form-control" type="file" id="siteLogo">
                                        <div class="form-text">Tamaño recomendado: 200x60px. Formatos: PNG, JPG, SVG.</div>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Configuración de Email -->
                    <div class="tab-pane fade" id="email" role="tabpanel" aria-labelledby="email-tab">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-envelope me-1"></i>
                                Configuración de Email
                            </div>
                            <div class="card-body">
                                <form>
                                    <div class="mb-3">
                                        <label for="mailDriver" class="form-label">Servicio de Email</label>
                                        <select class="form-select" id="mailDriver">
                                            <option value="smtp" selected>SMTP</option>
                                            <option value="sendmail">Sendmail</option>
                                            <option value="mailgun">Mailgun</option>
                                            <option value="ses">Amazon SES</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="mailHost" class="form-label">Host SMTP</label>
                                        <input type="text" class="form-control" id="mailHost" value="smtp.mailtrap.io">
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="mailPort" class="form-label">Puerto SMTP</label>
                                            <input type="text" class="form-control" id="mailPort" value="2525">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mailEncryption" class="form-label">Encriptación</label>
                                            <select class="form-select" id="mailEncryption">
                                                <option value="" selected>Ninguna</option>
                                                <option value="tls">TLS</option>
                                                <option value="ssl">SSL</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="mailUsername" class="form-label">Usuario SMTP</label>
                                            <input type="text" class="form-control" id="mailUsername" value="123456789">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mailPassword" class="form-label">Contraseña SMTP</label>
                                            <input type="password" class="form-control" id="mailPassword" value="abcdef123456">
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="mailFromAddress" class="form-label">Dirección de Envío</label>
                                            <input type="email" class="form-control" id="mailFromAddress" value="noreply@nvogestion.com">
                                        </div>
                                        <div class="col-md-6">
                                            <label for="mailFromName" class="form-label">Nombre de Envío</label>
                                            <input type="text" class="form-control" id="mailFromName" value="NvoGestion">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="button" class="btn btn-outline-primary">Enviar Email de Prueba</button>
                                    </div>
                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Copias de Seguridad -->
                    <div class="tab-pane fade" id="backup" role="tabpanel" aria-labelledby="backup-tab">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-database me-1"></i>
                                Copias de Seguridad
                            </div>
                            <div class="card-body">
                                <div class="mb-4">
                                    <h5>Copias de Seguridad Automáticas</h5>
                                    <div class="form-check form-switch mb-3">
                                        <input class="form-check-input" type="checkbox" id="autoBackup" checked>
                                        <label class="form-check-label" for="autoBackup">Habilitar copias de seguridad automáticas</label>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="backupFrequency" class="form-label">Frecuencia</label>
                                            <select class="form-select" id="backupFrequency">
                                                <option value="daily" selected>Diaria</option>
                                                <option value="weekly">Semanal</option>
                                                <option value="monthly">Mensual</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="backupTime" class="form-label">Hora</label>
                                            <input type="time" class="form-control" id="backupTime" value="03:00">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="backupRetention" class="form-label">Retención de Copias</label>
                                        <select class="form-select" id="backupRetention">
                                            <option value="7">7 días</option>
                                            <option value="14">14 días</option>
                                            <option value="30" selected>30 días</option>
                                            <option value="90">90 días</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="mb-4">
                                    <h5>Copias de Seguridad Manuales</h5>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="backupType" class="form-label">Tipo de Copia</label>
                                            <select class="form-select" id="backupType">
                                                <option value="full" selected>Completa (DB + Archivos)</option>
                                                <option value="db">Solo Base de Datos</option>
                                                <option value="files">Solo Archivos</option>
                                            </select>
                                        </div>
                                        <div class="col-md-6 d-flex align-items-end">
                                            <button type="button" class="btn btn-primary">Crear Copia de Seguridad</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <h5>Copias de Seguridad Disponibles</h5>
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Nombre</th>
                                                <th>Fecha</th>
                                                <th>Tamaño</th>
                                                <th>Tipo</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>backup_20250325_030000.zip</td>
                                                <td>25/03/2025 03:00:00</td>
                                                <td>145 MB</td>
                                                <td>Completa</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-download"></i></button>
                                                    <button class="btn btn-sm btn-outline-success me-1"><i class="fas fa-redo-alt"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>backup_20250324_030000.zip</td>
                                                <td>24/03/2025 03:00:00</td>
                                                <td>142 MB</td>
                                                <td>Completa</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-download"></i></button>
                                                    <button class="btn btn-sm btn-outline-success me-1"><i class="fas fa-redo-alt"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>backup_20250323_030000.zip</td>
                                                <td>23/03/2025 03:00:00</td>
                                                <td>138 MB</td>
                                                <td>Completa</td>
                                                <td>
                                                    <button class="btn btn-sm btn-outline-primary me-1"><i class="fas fa-download"></i></button>
                                                    <button class="btn btn-sm btn-outline-success me-1"><i class="fas fa-redo-alt"></i></button>
                                                    <button class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Notificaciones -->
                    <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                        <div class="card mb-4">
                            <div class="card-header">
                                <i class="fas fa-bell me-1"></i>
                                Configuración de Notificaciones
                            </div>
                            <div class="card-body">
                                <form>
                                    <h5 class="mb-3">Notificaciones por Email</h5>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailNewSurgery" checked>
                                            <label class="form-check-label" for="emailNewSurgery">Nuevas cirugías programadas</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailSurgeryReminder" checked>
                                            <label class="form-check-label" for="emailSurgeryReminder">Recordatorio de cirugías (24h antes)</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailSurgeryUpdate" checked>
                                            <label class="form-check-label" for="emailSurgeryUpdate">Cambios en cirugías programadas</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailLowStock">
                                            <label class="form-check-label" for="emailLowStock">Alertas de stock bajo</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="emailSystemBackup" checked>
                                            <label class="form-check-label" for="emailSystemBackup">Notificaciones de copias de seguridad</label>
                                        </div>
                                    </div>

                                    <h5 class="mb-3 mt-4">Notificaciones del Sistema</h5>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="systemNewSurgery" checked>
                                            <label class="form-check-label" for="systemNewSurgery">Nuevas cirugías programadas</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="systemSurgeryReminder" checked>
                                            <label class="form-check-label" for="systemSurgeryReminder">Recordatorio de cirugías</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="systemLowStock" checked>
                                            <label class="form-check-label" for="systemLowStock">Alertas de stock bajo</label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="systemUserActivity">
                                            <label class="form-check-label" for="systemUserActivity">Actividad de usuarios</label>
                                        </div>
                                    </div>

                                    <div class="d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary">Guardar Configuración</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Registros del Sistema -->
                    <div class="tab-pane fade" id="logs" role="tabpanel" aria-labelledby="logs-tab">
                        <div class="card mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <div>
                                    <i class="fas fa-list me-1"></i>
                                    Registros del Sistema
                                </div>
                                <div class="d-flex">
                                    <select class="form-select form-select-sm me-2" style="width: 150px;">
                                        <option value="all" selected>Todos los tipos</option>
                                        <option value="info">Información</option>
                                        <option value="warning">Advertencias</option>
                                        <option value="error">Errores</option>
                                        <option value="critical">Críticos</option>
                                    </select>
                                    <button class="btn btn-sm btn-outline-primary">Refrescar</button>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Fecha/Hora</th>
                                                <th>Nivel</th>
                                                <th>Usuario</th>
                                                <th>Mensaje</th>
                                                <th>IP</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>25/03/2025 10:05:23</td>
                                                <td><span class="badge bg-info">INFO</span></td>
                                                <td>admin@example.com</td>
                                                <td>Inicio de sesión exitoso</td>
                                                <td>192.168.1.100</td>
                                            </tr>
                                            <tr>
                                                <td>25/03/2025 09:58:12</td>
                                                <td><span class="badge bg-warning">WARNING</span></td>
                                                <td>sistema</td>
                                                <td>Stock bajo en artículo: Gasas Estériles (12 unidades)</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>25/03/2025 09:45:36</td>
                                                <td><span class="badge bg-success">SUCCESS</span></td>
                                                <td>sistema</td>
                                                <td>Copia de seguridad completada con éxito: backup_20250325_030000.zip</td>
                                                <td>-</td>
                                            </tr>
                                            <tr>
                                                <td>25/03/2025 08:32:15</td>
                                                <td><span class="badge bg-info">INFO</span></td>
                                                <td>ana@example.com</td>
                                                <td>Nueva cirugía programada: ID #45 - Artroscopía de Rodilla</td>
                                                <td>192.168.1.105</td>
                                            </tr>
                                            <tr>
                                                <td>24/03/2025 16:18:42</td>
                                                <td><span class="badge bg-danger">ERROR</span></td>
                                                <td>sistema</td>
                                                <td>Error de conexión con el servidor de correo: timeout</td>
                                                <td>-</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <nav aria-label="Page navigation example">
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
                                <div class="d-flex justify-content-end">
                                    <button class="btn btn-outline-primary me-2">Descargar Registros</button>
                                    <button class="btn btn-outline-danger">Limpiar Registros</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection