<?php

namespace Modules\Despacho\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Despacho extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'despachos';

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array
     */
    protected $fillable = [
        'pedido_id',
        'estado',
        'fecha_despacho',
        'destinatario',
        'direccion',
        'telefono',
        'email_contacto',
        'ruta_id',
        'transportista_id',
        'costo_envio',
        'observaciones',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_despacho' => 'datetime',
        'costo_envio' => 'float',
    ];

    /**
     * Configuración para el registro de actividad.
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['pedido_id', 'estado', 'fecha_despacho', 'destinatario', 'direccion', 'observaciones'])
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * Relación con el modelo Pedido.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pedido()
    {
        return $this->belongsTo(\Modules\Pedido\Models\Pedido::class);
    }

    /**
     * Relación con el modelo Ruta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ruta()
    {
        return $this->belongsTo(\Modules\Despacho\Models\Ruta::class);
    }

    /**
     * Relación con el modelo Transportista.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function transportista()
    {
        return $this->belongsTo(\Modules\Despacho\Models\Transportista::class);
    }

    /**
     * Relación con el historial de estados.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function historiales()
    {
        return $this->hasMany(\Modules\Despacho\Models\DespachoHistorial::class);
    }

    /**
     * Scope para filtrar despachos por estado.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $estado
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEstado($query, $estado)
    {
        return $query->where('estado', $estado);
    }

    /**
     * Scope para filtrar despachos por fecha.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $fecha
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFecha($query, $fecha)
    {
        return $query->whereDate('fecha_despacho', $fecha);
    }

    /**
     * Scope para filtrar despachos pendientes de entrega.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePendientes($query)
    {
        return $query->whereIn('estado', ['pendiente', 'en_proceso', 'despachado']);
    }
}
