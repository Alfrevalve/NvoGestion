<?php

namespace Modules\Almacen\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categoria extends Model
{
    use HasFactory;

    protected $table = 'categorias';

    protected $fillable = [
        'nombre',
        'descripcion'
    ];

    // Relación con Inventario
    public function inventarios()
    {
        return $this->hasMany(Inventario::class);
    }

    protected static function newFactory()
    {
        return \Modules\Almacen\Database\factories\CategoriaFactory::new();
    }
}
