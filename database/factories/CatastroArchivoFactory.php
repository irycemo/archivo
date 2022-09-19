<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CatastroArchivo>
 */
class CatastroArchivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'estado' => $this->faker->randomElement(['disponible', 'ocupado']),
            'tomo' => $this->faker->randomNumber,
            'localidad' => $this->faker->numberBetween(1,7),
            'oficina' => 101,
            'tipo' => $this->faker->numberBetween(1,2),
            'registro' => $this->faker->numberBetween(1,100000),
            'folio' => $this->faker->randomNumber,
            'tarjeta' => $this->faker->numberBetween(0,1)
        ];
    }
}
