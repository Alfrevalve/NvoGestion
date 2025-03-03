<?php

namespace Modules\Almacen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventario extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'cantidad',
        'estado',
        'ubicacion',
        'tipo',
        'descripcion',
        'codigo',
        'precio_unitario',
        'stock_minimo',
        'stock_maximo',
        'fecha_ultima_entrada',
        'fecha_ultima_salida',
        'proveedor_id',
        'categoria_id',
    ];

    protected $casts = [
        'fecha_ultima_entrada' => 'datetime',
        'fecha_ultima_salida' => 'datetime',
        'precio_unitario' => 'decimal:2',
    ];

    // Relación con Proveedor
    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class);
    }

    // Relación con Categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

    // Relación con Movimientos
    public function movimientos()
    {
        return $this->hasMany(MovimientoInventario::class);
    }

    // Scope para filtrar por estado
    public function scopeDisponible($query)
    {
        return $query->where('estado', 'disponible');
    }

    public function scopeAgotado($query)
    {
        return $query->where('estado', 'agotado');
    }

    public function scopeReservado($query)
    {
        return $query->where('estado', 'reservado');
    }

    // Scope para filtrar por stock bajo
    public function scopeStockBajo($query)
    {
        return $query->whereRaw('cantidad <= stock_minimo');
    }

    // Métodos adicionales
    public function actualizarStock($cantidad, $tipo = 'entrada')
    {
        if ($tipo === 'entrada') {
            $this->cantidad += $cantidad;
            $this->fecha_ultima_entrada = now();
        } else {
            $this->cantidad -= $cantidad;
            $this->fecha_ultima_salida = now();
        }

        $this->actualizarEstado();
        $this->save();
    }

    protected function actualizarEstado()
    {
        if ($this->cantidad <= 0) {
            $this->estado = 'agotado';
        } elseif ($this->cantidad <= $this->stock_minimo) {
            $this->estado = 'stock_bajo';
        } else {
            $this->estado = 'disponible';
        }
    }

    public function getValorTotalAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }

    protected static function newFactory()
    {
        return \Modules\Almacen\Database\factories\InventarioFactory::new();
    }
}
