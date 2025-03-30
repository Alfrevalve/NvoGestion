<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Error 404</div>
                <div class="card-body">
                    <p>La página que está buscando no existe.</p>
                    <a href="<?php echo e(url('/')); ?>" class="btn btn-primary">Volver al Inicio</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\NvoGestionv2\NvoGestion\resources\views/errors/404.blade.php ENDPATH**/ ?>