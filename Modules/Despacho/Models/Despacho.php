<?php

namespace Modules\Despacho\Models;

use Illuminate\Database\Eloquent\Model;

class Despacho extends Model
{
    protected $table = 'despachos';

    protected $fillable = [
        'pedido_id',
        'estado',
        'fecha_despacho',
        'destinatario',
        'direccion',
        'observaciones',
    ];

    // Additional methods and relationships can be defined here
}
