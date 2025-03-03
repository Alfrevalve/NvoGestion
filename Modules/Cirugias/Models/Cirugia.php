<?php

namespace Modules\Cirugias\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Cirugia extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'cirugias';

    protected $fillable = [
        'fecha',
        'hora',
        'tipo_cirugia',
        'institucion_id',
        'medico_id',
        'instrumentista_id',
        'equipo_id',
        'estado',
        'prioridad',
        'duracion_estimada',
        'observaciones'
    ];

    // Con $casts se maneja la conversión de fecha y hora (se puede eliminar $dates)
    protected $casts = [
        'fecha' => 'date',
        'hora' => 'datetime',
        'duracion_estimada' => 'integer'
    ];

    // Agregar los atributos calculados al array de salida
    protected $appends = ['estado_color', 'prioridad_color'];

    // Relaciones
    public function institucion()
    {
        return $this->belongsTo(Institucion::class);
    }

    public function medico()
    {
        return $this->belongsTo(Medico::class);
    }

    public function instrumentista()
    {
        return $this->belongsTo(Instrumentista::class);
    }

    public function equipo()
    {
        return $this->belongsTo(Equipo::class);
    }

    public function materiales()
    {
        return $this->belongsToMany(Material::class, 'cirugia_material')
            ->withPivot('cantidad_usada')
            ->withTimestamps();
    }

    // Scopes
    public function scopePendientes($query)
    {
        return $query->where('estado', 'pendiente');
    }

    public function scopeProgramadas($query)
    {
        return $query->where('estado', 'programada');
    }

    public function scopeEnProceso($query)
    {
        return $query->where('estado', 'en proceso');
    }

    public function scopeFinalizadas($query)
    {
        return $query->where('estado', 'finalizada');
    }

    public function scopePrioridad($query, $prioridad)
    {
        return $query->where('prioridad', $prioridad);
    }

    /**
     * Scope para filtrar cirugías entre dos fechas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $desde
     * @param string $hasta
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeFechaEntre($query, string $desde, string $hasta)
    {
        return $query->whereBetween('fecha', [$desde, $hasta]);
    }

    // Mutadores
    public function setFechaAttribute($value)
    {
        $this->attributes['fecha'] = Carbon::parse($value)->format('Y-m-d');
    }

    public function setHoraAttribute($value)
    {
        $this->attributes['hora'] = Carbon::parse($value)->format('H:i:s');
    }

    // Accesores
    public function getEstadoColorAttribute()
    {
        $colors = [
            'pendiente'  => 'primary',
            'programada' => 'info',
            'en proceso' => 'warning',
            'finalizada' => 'success',
            'cancelada'  => 'danger',
        ];

        return $colors[$this->estado] ?? 'secondary';
    }

    public function getPrioridadColorAttribute()
    {
        $colors = [
            'baja'   => 'success',
            'media'  => 'info',
            'alta'   => 'warning',
            'urgente'=> 'danger',
        ];

        return $colors[$this->prioridad] ?? 'secondary';
    }

    // Factory
    protected static function newFactory()
    {
        return \Modules\Cirugias\Database\factories\CirugiaFactory::new();
    }
}
