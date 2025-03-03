<?php

namespace Modules\Cirugias\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Modelo Instrumentista
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $telefono
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property \Illuminate\Database\Eloquent\Collection|Cirugia[] $cirugias
 */
class Instrumentista extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'instrumentistas';

    protected $fillable = [
        'nombre',
        'telefono',
        'email'
    ];

    /**
     * Relación: Un instrumentista tiene muchas cirugías.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cirugias()
    {
        return $this->hasMany(Cirugia::class);
    }

    /**
     * Scope para obtener instrumentistas disponibles, es decir, que no tengan cirugías
     * programadas en una fecha y hora determinada.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string|Carbon $fecha
     * @param string $hora
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisponible($query, $fecha, string $hora)
    {
        // Aseguramos que la fecha esté en formato Y-m-d
        $fecha = $fecha instanceof Carbon ? $fecha->format('Y-m-d') : $fecha;

        return $query->whereDoesntHave('cirugias', function ($query) use ($fecha, $hora) {
            $query->where('fecha', $fecha)
                  ->where('hora', $hora)
                  ->whereIn('estado', ['programada', 'en proceso']);
        });
    }

    /**
     * Obtiene las cirugías del día para este instrumentista.
     *
     * @param string|Carbon $fecha
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getCirugiasDelDia($fecha)
    {
        $fecha = $fecha instanceof Carbon ? $fecha->format('Y-m-d') : $fecha;

        return $this->cirugias()
            ->where('fecha', $fecha)
            ->orderBy('hora')
            ->get();
    }

    /**
     * Obtiene las próximas cirugías para este instrumentista, a partir de la fecha actual.
     *
     * @param int $limite
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getProximasCirugias(int $limite = 5)
    {
        return $this->cirugias()
            ->where('fecha', '>=', Carbon::now()->format('Y-m-d'))
            ->orderBy('fecha')
            ->orderBy('hora')
            ->limit($limite)
            ->get();
    }

    /**
     * Define una nueva factory para el modelo.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Cirugias\Database\factories\InstrumentistaFactory::new();
    }
}
