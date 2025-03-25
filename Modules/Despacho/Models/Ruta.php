<?php

namespace Modules\Despacho\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Cache;
use Modules\Despacho\Database\Factories\RutaFactory;
use Carbon\Carbon;

/**
 * Class Ruta
 *
 * Modelo que representa una ruta de despacho en el sistema logístico.
 *
 * @package Modules\Despacho\Models
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $descripcion
 * @property string $origen
 * @property string $destino
 * @property float $distancia
 * @property int $tiempo_estimado Tiempo estimado en minutos
 * @property bool $activo
 * @property int|null $zona_id
 * @property float|null $costo_base
 * @property string|null $tipo_ruta
 * @property float|null $latitud_origen
 * @property float|null $longitud_origen
 * @property float|null $latitud_destino
 * @property float|null $longitud_destino
 * @property float|null $factor_riesgo
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Carbon|null $deleted_at
 */
class Ruta extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * Tipos de rutas disponibles en el sistema
     */
    const TIPO_URBANA = 'urbana';
    const TIPO_INTERURBANA = 'interurbana';
    const TIPO_RURAL = 'rural';
    const TIPO_INTERNACIONAL = 'internacional';

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'rutas';

    /**
     * Los atributos que son asignables masivamente.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'nombre',
        'descripcion',
        'origen',
        'destino',
        'distancia',
        'tiempo_estimado',
        'activo',
        'zona_id',
        'costo_base',
        'tipo_ruta',
        'latitud_origen',
        'longitud_origen',
        'latitud_destino',
        'longitud_destino',
        'factor_riesgo'
    ];

    /**
     * Los atributos que deben ocultarse en los arrays.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'deleted_at',
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'distancia' => 'float',
        'tiempo_estimado' => 'integer',
        'activo' => 'boolean',
        'costo_base' => 'float',
        'latitud_origen' => 'float',
        'longitud_origen' => 'float',
        'latitud_destino' => 'float',
        'longitud_destino' => 'float',
        'factor_riesgo' => 'float',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Crea una nueva instancia de factory para el modelo.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return RutaFactory::new();
    }

    /**
     * Inicializa el modelo con valores predeterminados.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($ruta) {
            // Si no se proporciona un factor de riesgo, calcular uno predeterminado
            if (is_null($ruta->factor_riesgo)) {
                $ruta->factor_riesgo = $ruta->calcularFactorRiesgo();
            }
        });

        static::saved(function ($ruta) {
            // Limpiar caché cuando se actualiza o crea una ruta
            Cache::forget('rutas_activas');
        });

        static::deleted(function ($ruta) {
            // Limpiar caché cuando se elimina una ruta
            Cache::forget('rutas_activas');
        });
    }

    /*
    |--------------------------------------------------------------------------
    | Relaciones
    |--------------------------------------------------------------------------
    */

    /**
     * Relación con los vehículos asignados a esta ruta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function vehiculos()
    {
        return $this->hasMany(Vehiculo::class);
    }

    /**
     * Relación con los despachos que utilizan esta ruta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function despachos()
    {
        return $this->hasMany(Despacho::class);
    }

    /**
     * Relación con la zona geográfica a la que pertenece la ruta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function zona()
    {
        return $this->belongsTo(Zona::class);
    }

    /**
     * Relación con los puntos de control (checkpoints) de esta ruta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function puntosControl()
    {
        return $this->hasMany(PuntoControl::class)->orderBy('orden');
    }

    /**
     * Relación con los transportistas que pueden operar en esta ruta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function transportistas()
    {
        return $this->belongsToMany(Transportista::class, 'ruta_transportista')
                    ->withPivot('habilitado', 'costo_especial')
                    ->withTimestamps();
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes
    |--------------------------------------------------------------------------
    */

    /**
     * Scope para filtrar solo rutas activas.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeActivas(Builder $query): Builder
    {
        return $query->where('activo', true);
    }

    /**
     * Scope para filtrar por tipo de ruta.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $tipo
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeTipo(Builder $query, string $tipo): Builder
    {
        return $query->where('tipo_ruta', $tipo);
    }

    /**
     * Scope para filtrar rutas por origen.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $origen
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorOrigen(Builder $query, string $origen): Builder
    {
        return $query->where('origen', 'LIKE', "%{$origen}%");
    }

    /**
     * Scope para filtrar rutas por destino.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $destino
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePorDestino(Builder $query, string $destino): Builder
    {
        return $query->where('destino', 'LIKE', "%{$destino}%");
    }

    /**
     * Scope para filtrar rutas por distancia máxima.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $distanciaMax
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDistanciaMaxima(Builder $query, float $distanciaMax): Builder
    {
        return $query->where('distancia', '<=', $distanciaMax);
    }

    /**
     * Scope para buscar rutas disponibles entre dos puntos.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $origen
     * @param string $destino
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEntreOrigenYDestino(Builder $query, string $origen, string $destino): Builder
    {
        return $query->where('origen', 'LIKE', "%{$origen}%")
                     ->where('destino', 'LIKE', "%{$destino}%")
                     ->where('activo', true)
                     ->orderBy('tiempo_estimado');
    }

    /*
    |--------------------------------------------------------------------------
    | Accessors & Mutators
    |--------------------------------------------------------------------------
    */

    /**
     * Obtiene el tiempo estimado formateado en horas y minutos.
     *
     * @return string
     */
    public function getTiempoEstimadoFormateadoAttribute(): string
    {
        $horas = floor($this->tiempo_estimado / 60);
        $minutos = $this->tiempo_estimado % 60;

        if ($horas > 0) {
            return "{$horas}h {$minutos}m";
        }

        return "{$minutos}m";
    }

    /**
     * Obtiene la distancia formateada con unidad de medida.
     *
     * @return string
     */
    public function getDistanciaFormateadaAttribute(): string
    {
        if ($this->distancia >= 1) {
            return number_format($this->distancia, 1) . ' km';
        }

        // Convertir a metros si es menos de 1 km
        return number_format($this->distancia * 1000) . ' m';
    }

    /**
     * Obtiene el nombre completo de la ruta (origen - destino).
     *
     * @return string
     */
    public function getRutaCompletaAttribute(): string
    {
        return "{$this->origen} - {$this->destino}";
    }

    /**
     * Obtiene el estado de la ruta en formato texto.
     *
     * @return string
     */
    public function getEstadoTextoAttribute(): string
    {
        return $this->activo ? 'Activa' : 'Inactiva';
    }

    /*
    |--------------------------------------------------------------------------
    | Métodos adicionales
    |--------------------------------------------------------------------------
    */

    /**
     * Calcula el costo de transporte para esta ruta basado en la distancia y otros factores.
     *
     * @param float $peso Peso en kg de la carga
     * @param float $volumen Volumen en m³ de la carga
     * @return float
     */
    public function calcularCostoTransporte(float $peso = 0, float $volumen = 0): float
    {
        // Costo base de la ruta
        $costo = $this->costo_base ?: ($this->distancia * 0.5);

        // Factores adicionales
        $factorPeso = $peso > 0 ? ($peso * 0.1) : 0;
        $factorVolumen = $volumen > 0 ? ($volumen * 0.2) : 0;
        $factorRiesgo = ($this->factor_riesgo ?: 1) * $costo * 0.05;

        return round($costo + $factorPeso + $factorVolumen + $factorRiesgo, 2);
    }

    /**
     * Calcula un factor de riesgo basado en la distancia y el tipo de ruta.
     *
     * @return float
     */
    public function calcularFactorRiesgo(): float
    {
        // Factores base según el tipo de ruta
        $factoresTipo = [
            self::TIPO_URBANA => 1.0,
            self::TIPO_INTERURBANA => 1.2,
            self::TIPO_RURAL => 1.5,
            self::TIPO_INTERNACIONAL => 1.8,
        ];

        $factorBase = $factoresTipo[$this->tipo_ruta] ?? 1.0;

        // Aumentar factor según la distancia
        $factorDistancia = 1.0;
        if ($this->distancia > 500) {
            $factorDistancia = 1.3;
        } elseif ($this->distancia > 200) {
            $factorDistancia = 1.2;
        } elseif ($this->distancia > 100) {
            $factorDistancia = 1.1;
        }

        return round($factorBase * $factorDistancia, 2);
    }

    /**
     * Activa o desactiva la ruta.
     *
     * @param bool $activo
     * @return bool
     */
    public function cambiarEstado(bool $activo): bool
    {
        $this->activo = $activo;
        return $this->save();
    }

    /**
     * Determina si la ruta está siendo utilizada en despachos activos.
     *
     * @return bool
     */
    public function tieneDespachosPendientes(): bool
    {
        return $this->despachos()
                    ->whereIn('estado', ['pendiente', 'en_proceso', 'despachado'])
                    ->exists();
    }

    /**
     * Obtiene las coordenadas de origen y destino en formato adecuado para APIs de mapas.
     *
     * @return array
     */
    public function obtenerCoordenadas(): array
    {
        return [
            'origen' => [
                'lat' => $this->latitud_origen,
                'lng' => $this->longitud_origen,
                'nombre' => $this->origen
            ],
            'destino' => [
                'lat' => $this->latitud_destino,
                'lng' => $this->longitud_destino,
                'nombre' => $this->destino
            ]
        ];
    }

    /**
     * Obtiene todas las rutas activas (con caché).
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function obtenerRutasActivas()
    {
        return Cache::remember('rutas_activas', 3600, function () {
            return self::activas()->orderBy('nombre')->get();
        });
    }

    /**
     * Obtiene el total de despachos realizados por esta ruta.
     *
     * @return int
     */
    public function totalDespachos(): int
    {
        return $this->despachos()->count();
    }

    /**
     * Obtiene el tiempo promedio real de los despachos realizados en esta ruta.
     *
     * @return int|null Tiempo promedio en minutos o null si no hay datos
     */
    public function tiempoPromedioReal(): ?int
    {
        $despachos = $this->despachos()
                         ->whereNotNull('fecha_salida')
                         ->whereNotNull('fecha_llegada')
                         ->get();

        if ($despachos->isEmpty()) {
            return null;
        }

        $tiempoTotal = 0;
        $contador = 0;

        foreach ($despachos as $despacho) {
            if ($despacho->fecha_salida && $despacho->fecha_llegada) {
                $tiempoTotal += $despacho->fecha_llegada->diffInMinutes($despacho->fecha_salida);
                $contador++;
            }
        }

        return $contador > 0 ? intval($tiempoTotal / $contador) : null;
    }
}
