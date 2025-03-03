<?php

namespace Modules\Cirugias\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Modelo Equipo
 *
 * @property string $nombre
 * @property string $codigo
 * @property string $estado
 * @property string|null $descripcion
 * @property \Carbon\Carbon|null $fecha_mantenimiento
 */
class Equipo extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'equipos';

    protected $fillable = [
        'nombre',
        'codigo',
        'estado',
        'descripcion',
        'fecha_mantenimiento'
    ];

    /**
     * Atributos a castear automáticamente.
     *
     * Se usa $casts en lugar de $dates para manejar conversiones de fecha.
     *
     * @var array
     */
    protected $casts = [
        'fecha_mantenimiento' => 'date',
        'created_at'          => 'datetime',
        'updated_at'          => 'datetime',
        'deleted_at'          => 'datetime',
    ];

    // Estados posibles
    const ESTADO_DISPONIBLE    = 'disponible';
    const ESTADO_EN_USO       = 'en uso';
    const ESTADO_MANTENIMIENTO = 'mantenimiento';
    const ESTADO_FUERA_SERVICIO= 'fuera de servicio';

    // Relaciones
    public function cirugias()
    {
        return $this->hasMany(Cirugia::class);
    }

    // Scopes
    /**
     * Scope para equipos disponibles.
     */
    public function scopeDisponible($query)
    {
        return $query->where('estado', self::ESTADO_DISPONIBLE);
    }

    /**
     * Scope para equipos en mantenimiento.
     */
    public function scopeEnMantenimiento($query)
    {
        return $query->where('estado', self::ESTADO_MANTENIMIENTO);
    }

    /**
     * Scope para equipos en uso.
     */
    public function scopeEnUso($query)
    {
        return $query->where('estado', self::ESTADO_EN_USO);
    }

    /**
     * Scope para equipos fuera de servicio.
     */
    public function scopeFueraDeServicio($query)
    {
        return $query->where('estado', self::ESTADO_FUERA_SERVICIO);
    }

    /**
     * Scope para equipos que requieren mantenimiento en los próximos $dias días.
     * Se asegura de que la fecha de mantenimiento esté en el futuro.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $dias
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeMantenimientoProximo($query, int $dias = 7)
    {
        return $query->whereNotNull('fecha_mantenimiento')
                     ->whereDate('fecha_mantenimiento', '>=', now())
                     ->whereDate('fecha_mantenimiento', '<=', now()->addDays($dias));
    }

    // Métodos de instancia

    /**
     * Indica si el equipo está disponible.
     *
     * @return bool
     */
    public function estaDisponible(): bool
    {
        return $this->estado === self::ESTADO_DISPONIBLE;
    }

    /**
     * Marca el equipo como en uso.
     *
     * @return bool
     */
    public function marcarComoEnUso(): bool
    {
        return $this->update(['estado' => self::ESTADO_EN_USO]);
    }

    /**
     * Marca el equipo como disponible.
     *
     * @return bool
     */
    public function marcarComoDisponible(): bool
    {
        return $this->update(['estado' => self::ESTADO_DISPONIBLE]);
    }

    /**
     * Marca el equipo como en mantenimiento.
     *
     * @return bool
     */
    public function marcarComoEnMantenimiento(): bool
    {
        return $this->update(['estado' => self::ESTADO_MANTENIMIENTO]);
    }

    /**
     * Marca el equipo como fuera de servicio.
     *
     * @return bool
     */
    public function marcarComoFueraDeServicio(): bool
    {
        return $this->update(['estado' => self::ESTADO_FUERA_SERVICIO]);
    }

    /**
     * Programa el mantenimiento del equipo en la fecha especificada.
     *
     * @param  string|\Carbon\Carbon $fecha
     * @return bool
     */
    public function programarMantenimiento($fecha): bool
    {
        return $this->update(['fecha_mantenimiento' => Carbon::parse($fecha)]);
    }

    // Accesores

    /**
     * Devuelve el color asociado al estado del equipo.
     *
     * @return string
     */
    public function getEstadoColorAttribute(): string
    {
        $colors = [
            self::ESTADO_DISPONIBLE    => 'success',
            self::ESTADO_EN_USO       => 'warning',
            self::ESTADO_MANTENIMIENTO => 'info',
            self::ESTADO_FUERA_SERVICIO=> 'danger',
        ];

        return $colors[$this->estado] ?? 'secondary';
    }

    /**
     * Indica si el equipo requiere mantenimiento (si la fecha ya pasó).
     *
     * @return bool
     */
    public function getRequiereMantenimientoAttribute(): bool
    {
        return $this->fecha_mantenimiento ? $this->fecha_mantenimiento->isPast() : false;
    }

    // Factory
    protected static function newFactory()
    {
        return \Modules\Cirugias\Database\factories\EquipoFactory::new();
    }
}
