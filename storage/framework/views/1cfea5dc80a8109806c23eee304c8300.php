

<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-between mb-4">
        <div class="col-md-6">
            <h1>Gestión de Cirugías</h1>
        </div>
        <div class="col-md-6 text-right">
            <a href="<?php echo e(route('cirugias.calendario')); ?>" class="btn btn-info">Ver Calendario</a>
            <a href="#" class="btn btn-primary">Nueva Cirugía</a>
        </div>
    </div>

    <div class="card">
        <div class="card-header">
            <h3>Listado de Cirugías</h3>
        </div>
        <div class="card-body">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Fecha</th>
                        <th>Paciente</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__empty_1 = true; $__currentLoopData = $cirugias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cirugia): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <tr>
                        <td><?php echo e($cirugia->id); ?></td>
                        <td><?php echo e($cirugia->nombre); ?></td>
                        <td><?php echo e($cirugia->fecha_inicio ? $cirugia->fecha_inicio->format('d/m/Y H:i') : 'No definida'); ?></td>
                        <td><?php echo e($cirugia->paciente ? $cirugia->paciente->nombre : 'No asignado'); ?></td>
                        <td>
                            <span class="badge badge-<?php echo e($cirugia->estado == 'Completada' ? 'success' : ($cirugia->estado == 'Pendiente' ? 'warning' : 'info')); ?>">
                                <?php echo e($cirugia->estado ?? 'Pendiente'); ?>

                            </span>
                        </td>
                        <td>
                            <a href="#" class="btn btn-sm btn-info">Ver</a>
                            <a href="#" class="btn btn-sm btn-primary">Editar</a>
                            <a href="#" class="btn btn-sm btn-danger">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <tr>
                        <td colspan="6" class="text-center">No hay cirugías registradas</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NvoGestionv2\NvoGestion\resources\views/modulo/cirugias/index.blade.php ENDPATH**/ ?>