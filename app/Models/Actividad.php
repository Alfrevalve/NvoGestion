<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Actividad extends Model
{
    use HasFactory;

    protected $table = 'actividades';

    protected $fillable = [
        'user_id',
        'tipo',
        'descripcion',
        'detalles',
        'modelo_type',
        'modelo_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Obtiene el usuario que realizó la actividad.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Obtiene el modelo relacionado con la actividad.
     */
    public function modelo()
    {
        return $this->morphTo();
    }

    /**
     * Registra una nueva actividad en el sistema.
     */
    public static function registrar($tipo, $descripcion, $detalles = null, $modelo = null)
    {
        return static::create([
            'user_id' => auth()->id(),
            'tipo' => $tipo,
            'descripcion' => $descripcion,
            'detalles' => $detalles,
            'modelo_type' => $modelo ? get_class($modelo) : null,
            'modelo_id' => $modelo ? $modelo->id : null,
        ]);
    }

    /**
     * Scope para filtrar por tipo de actividad.
     */
    public function scopeTipo($query, $tipo)
    {
        return $query->where('tipo', $tipo);
    }

    /**
     * Scope para filtrar por usuario.
     */
    public function scopeDeUsuario($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope para obtener actividades recientes.
     */
    public function scopeRecientes($query, $dias = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($dias));
    }
}