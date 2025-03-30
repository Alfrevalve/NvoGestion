<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    use HasFactory;

    protected $fillable = [
        // Define the fillable attributes for the Paciente model
        'name',
        'age',
        'gender',
        'address',
        'phone',
        // Add other relevant fields as necessary
    ];
}
