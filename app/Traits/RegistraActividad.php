<?php

namespace App\Traits;

use App\Models\Actividad;

trait RegistraActividad
{
    /**
     * Boot the trait.
     *
     * @return void
     */
    protected static function bootRegistraActividad()
    {
        static::created(function ($model) {
            $model->registrarActividad('creado');
        });

        static::updated(function ($model) {
            if ($model->wasChanged()) {
                $model->registrarActividad('actualizado');
            }
        });

        static::deleted(function ($model) {
            $model->registrarActividad('eliminado');
        });
    }

    /**
     * Registra una actividad para este modelo.
     *
     * @param string $accion
     * @return void
     */
    public function registrarActividad($accion)
    {
        if (!auth()->check()) {
            return;
        }

        $modelName = class_basename($this);
        $modelId = $this->getKey();
        
        // Determinar el tipo basado en el namespace
        $tipo = $this->getTipoActividad();
        
        // Crear una descripción legible
        $descripcion = "{$modelName} #{$modelId} fue {$accion}";
        
        // Recopilar detalles de los cambios si fue actualizado
        $detalles = null;
        if ($accion === 'actualizado' && method_exists($this, 'getActivitiesAttributes')) {
            $cambios = array_intersect_key($this->getChanges(), array_flip($this->getActivitiesAttributes()));
            if (!empty($cambios)) {
                $detalles = json_encode($cambios);
            }
        }
        
        // Registrar la actividad
        Actividad::registrar($tipo, $descripcion, $detalles, $this);
    }
    
    /**
     * Determina el tipo de actividad basado en el namespace del modelo.
     *
     * @return string
     */
    protected function getTipoActividad()
    {
        $class = get_class($this);
        
        if (strpos($class, 'Modules\\Cirugias') !== false) {
            return 'cirugia';
        } elseif (strpos($class, 'Modules\\Almacen') !== false) {
            return 'inventario';
        } elseif (strpos($class, 'Modules\\Despacho') !== false) {
            return 'despacho';
        } elseif (strpos($class, 'App\\Models\\User') !== false) {
            return 'usuario';
        }
        
        return 'sistema';
    }
    
    /**
     * Define los atributos a monitorear para actividades.
     * Debe ser implementado por las clases que usan este trait.
     *
     * @return array
     */
    public function getActivitiesAttributes()
    {
        // Por defecto, usar fillable si está disponible
        if (property_exists($this, 'fillable')) {
            return $this->fillable;
        }
        
        return [];
    }
}