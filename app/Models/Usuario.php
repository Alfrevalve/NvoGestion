<?php
declare(strict_types=1);

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Usuario extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $table = 'usuarios';
    protected $primaryKey = 'id_usuario';

    protected $fillable = [
        'nombre',
        'apellidos',
        'email',
        'password',
        'tipo_usuario',
        'telefono',
        'direccion',
        'activo',
        'last_seen_at',
        'remember_token',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];
}
