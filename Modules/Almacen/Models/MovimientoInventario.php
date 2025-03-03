<?php

namespace Modules\Almacen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class MovimientoInventario extends Model
{
    use HasFactory;

    protected $table = 'movimientos_inventario';

    protected $fillable = [
        'inventario_id',
        'tipo',
        'cantidad',
        'precio_unitario',
        'referencia',
        'observaciones',
        'user_id'
    ];

    protected $casts = [
        'precio_unitario' => 'decimal:2',
        'created_at' => 'datetime',
    ];

    // Relación con Inventario
    public function inventario()
    {
        return $this->belongsTo(Inventario::class);
    }

    // Relación con Usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Scope para filtrar por tipo de movimiento
    public function scopeEntradas($query)
    {
        return $query->where('tipo', 'entrada');
    }

    public function scopeSalidas($query)
    {
        return $query->where('tipo', 'salida');
    }

    // Scope para filtrar por fecha
    public function scopeFecha($query, $fecha)
    {
        return $query->whereDate('created_at', $fecha);
    }

    // Scope para filtrar por rango de fechas
    public function scopeRangoFechas($query, $desde, $hasta)
    {
        return $query->whereBetween('created_at', [$desde, $hasta]);
    }

    // Atributo calculado para el valor total del movimiento
    public function getValorTotalAttribute()
    {
        return $this->cantidad * $this->precio_unitario;
    }

    // Método para registrar un movimiento y actualizar el inventario
    public static function registrarMovimiento($datos)
    {
        \DB::transaction(function () use ($datos) {
            $movimiento = self::create($datos);

            $inventario = $movimiento->inventario;
            $inventario->actualizarStock(
                $movimiento->cantidad,
                $movimiento->tipo
            );
        });
    }

    protected static function newFactory()
    {
        return \Modules\Almacen\Database\factories\MovimientoInventarioFactory::new();
    }
}
