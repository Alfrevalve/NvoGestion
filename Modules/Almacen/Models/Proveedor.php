<?php

namespace Modules\Almacen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proveedor extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'proveedores';

    protected $fillable = [
        'nombre',
        'contacto',
        'telefono',
        'email',
        'direccion'
    ];

    // Relación con Inventario
    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    // Relación con MovimientoInventario
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    // Scope para búsqueda
    public function scopeSearch($query, $term)
    {
        if ($term) {
            return $query->where('nombre', 'LIKE', "%{$term}%")
                        ->orWhere('contacto', 'LIKE', "%{$term}%")
                        ->orWhere('email', 'LIKE', "%{$term}%");
        }
        return $query;
    }

    protected static function newFactory()
    {
        return \Modules\Almacen\Database\factories\ProveedorFactory::new();
    }
}
