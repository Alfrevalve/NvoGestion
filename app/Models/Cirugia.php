<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cirugia extends Model
{
    use HasFactory;

    protected $table = 'cirugias';

    protected $fillable = [
        'tipo',
        'status_actual',
        'ultima_actualizacion',
        'notas_seguimiento',
        'institucion_id',
        'medico_id',
        'instrumentista_id',
        'equipo_id',
        'fecha',
        'hora',
        'tipo_cirugia',
        'estado',
        'prioridad',
        'duracion_estimada',
        'observaciones',
        'nombre',
    ];
}
