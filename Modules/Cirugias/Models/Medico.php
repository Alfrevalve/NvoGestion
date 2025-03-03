<?php

namespace Modules\Cirugias\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cirugias\Models\Cirugia;

/**
 * Modelo Medico
 *
 * @property int $id
 * @property string $nombre
 * @property string $especialidad
 * @property string $matricula
 * @property string|null $telefono
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Cirugia[] $cirugias
 */
class Medico extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'medicos';

    protected $fillable = [
        'nombre',
        'especialidad',
        'matricula',
        'telefono',
        'email'
    ];

    /**
     * Relación: Un médico tiene muchas cirugías.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cirugias()
    {
        return $this->hasMany(Cirugia::class);
    }

    /**
     * Scope para filtrar médicos por especialidad.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $especialidad
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeEspecialidad($query, string $especialidad)
    {
        return $query->where('especialidad', $especialidad);
    }

    /**
     * Scope para obtener médicos disponibles en una fecha y hora dada.
     * Un médico se considera disponible si no tiene cirugías en estado "programada" o "en proceso" en esa fecha y hora.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string $fecha  Formato 'Y-m-d' o instancia de Carbon formateada previamente.
     * @param string $hora   Formato 'H:i:s' o 'H:i'
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeDisponible($query, $fecha, string $hora)
    {
        return $query->whereDoesntHave('cirugias', function ($query) use ($fecha, $hora) {
            $query->where('fecha', $fecha)
                  ->where('hora', $hora)
                  ->whereIn('estado', ['programada', 'en proceso']);
        });
    }

    /**
     * Define la factory para el modelo Medico.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Cirugias\Database\factories\MedicoFactory::new();
    }
}
