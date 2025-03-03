<?php

namespace Modules\Cirugias\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Modelo Material
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $codigo
 * @property int $stock
 * @property int $stock_minimo
 * @property string|null $descripcion
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property-read string $estado
 * @property-read string $estado_color
 *
 * @property \Illuminate\Database\Eloquent\Collection|\Modules\Cirugias\Models\Cirugia[] $cirugias
 */
class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'materiales';

    protected $fillable = [
        'nombre',
        'codigo',
        'stock',
        'stock_minimo',
        'descripcion'
    ];

    protected $casts = [
        'stock'         => 'integer',
        'stock_minimo'  => 'integer'
    ];

    // Agregar atributos calculados para que se incluyan automáticamente
    protected $appends = ['estado', 'estado_color'];

    /**
     * Relación: Un material pertenece a muchas cirugías.
     */
    public function cirugias()
    {
        return $this->belongsToMany(Cirugia::class, 'cirugia_material')
                    ->withPivot('cantidad_usada')
                    ->withTimestamps();
    }

    /**
     * Scope para obtener materiales con stock bajo.
     */
    public function scopeStockBajo($query)
    {
        return $query->whereRaw('stock <= stock_minimo');
    }

    /**
     * Scope para obtener materiales disponibles (stock > 0).
     */
    public function scopeDisponible($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope para obtener materiales agotados (stock == 0).
     */
    public function scopeAgotado($query)
    {
        return $query->where('stock', 0);
    }

    /**
     * Actualiza el stock del material.
     *
     * @param int $cantidad
     * @param string $tipo 'entrada' o 'salida'
     * @return void
     */
    public function actualizarStock(int $cantidad, string $tipo = 'entrada'): void
    {
        if ($tipo === 'entrada') {
            $this->increment('stock', $cantidad);
        } else {
            $this->decrement('stock', $cantidad);
        }
    }

    /**
     * Verifica si el material tiene stock suficiente.
     *
     * @param int $cantidad
     * @return bool
     */
    public function tieneStockSuficiente(int $cantidad): bool
    {
        return $this->stock >= $cantidad;
    }

    /**
     * Indica si el material requiere reposición (stock es menor o igual al stock mínimo).
     *
     * @return bool
     */
    public function requiereReposicion(): bool
    {
        return $this->stock <= $this->stock_minimo;
    }

    /**
     * Accesor para obtener el estado del material según el stock.
     *
     * @return string
     */
    public function getEstadoAttribute(): string
    {
        if ($this->stock === 0) {
            return 'agotado';
        }
        if ($this->stock <= $this->stock_minimo) {
            return 'stock_bajo';
        }
        return 'disponible';
    }

    /**
     * Accesor para obtener el color asociado al estado del material.
     *
     * @return string
     */
    public function getEstadoColorAttribute(): string
    {
        $colors = [
            'agotado'    => 'danger',
            'stock_bajo' => 'warning',
            'disponible' => 'success',
        ];

        return $colors[$this->estado] ?? 'secondary';
    }

    /**
     * Define la factory para el modelo Material.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Cirugias\Database\factories\MaterialFactory::new();
    }
}
