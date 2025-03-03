<?php

namespace Modules\Cirugias\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

/**
 * Modelo ReporteCirugia
 *
 * @property int $id
 * @property int $cirugia_id
 * @property int $instrumentista_id
 * @property Carbon $fecha_cirugia
 * @property string|null $descripcion
 * @property string|null $observaciones
 * @property \Carbon\Carbon|null $created_at
 * @property \Carbon\Carbon|null $updated_at
 * @property \Carbon\Carbon|null $deleted_at
 *
 * @property-read \Modules\Cirugias\Models\Cirugia $cirugia
 * @property-read \Modules\Cirugias\Models\Instrumentista $instrumentista
 */
class ReporteCirugia extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'cirugia_id',
        'instrumentista_id',
        'fecha_cirugia',
        'descripcion',
        'observaciones',
    ];

    /**
     * Conversión automática de atributos.
     *
     * @var array
     */
    protected $casts = [
        'fecha_cirugia' => 'date',
    ];

    /**
     * Relación: Un reporte de cirugía pertenece a una cirugía.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cirugia()
    {
        return $this->belongsTo(Cirugia::class);
    }

    /**
     * Relación: Un reporte de cirugía pertenece a un instrumentista.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function instrumentista()
    {
        return $this->belongsTo(Instrumentista::class);
    }

    /**
     * Define la factory para el modelo ReporteCirugia.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Cirugias\Database\factories\ReporteCirugiaFactory::new();
    }
}
