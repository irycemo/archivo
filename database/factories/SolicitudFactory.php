<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Solicitud>
 */
class SolicitudFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tiempo' => $this->faker->randomNumber,
            'estado' => $this->faker->randomElement(['nueva', 'transito', 'recibido', 'regresado']),
            'numero' => $this->faker->unique()->randomNumber
        ];
    }
}
