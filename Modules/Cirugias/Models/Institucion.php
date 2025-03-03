<?php

namespace Modules\Cirugias\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\Cirugias\Models\Cirugia;

/**
 * Modelo Institucion
 *
 * @property int $id
 * @property string $nombre
 * @property string|null $direccion
 * @property string|null $telefono
 * @property string|null $email
 * @property string|null $observaciones
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 *
 * @property-read \Illuminate\Database\Eloquent\Collection|Cirugia[] $cirugias
 */
class Institucion extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * La tabla asociada al modelo.
     *
     * @var string
     */
    protected $table = 'instituciones';

    /**
     * Atributos asignables de forma masiva.
     *
     * @var array
     */
    protected $fillable = [
        'nombre',
        'direccion',
        'telefono',
        'email',
        'observaciones'
    ];

    /**
     * Relación: Una institución tiene muchas cirugías.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function cirugias()
    {
        return $this->hasMany(Cirugia::class);
    }

    /**
     * Define una nueva factory para el modelo.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Cirugias\Database\factories\InstitucionFactory::new();
    }
}
