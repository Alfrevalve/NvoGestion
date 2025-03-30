<?php

namespace Database\Factories;

use App\Models\Equipo;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class EquipoFactory extends Factory
{
    protected $model = Equipo::class;

    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word() . ' ' . $this->faker->randomElement(['Monitor', 'Bomba', 'Microscopio']),
            'codigo' => strtoupper(Str::random(6)),
            'modelo' => 'Mod-' . $this->faker->numerify('###'),
            'serie' => 'SN-' . $this->faker->bothify('???###'),
        ];
    }
}
