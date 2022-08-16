<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Incidence>
 */
class IncidenceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tipo' => $this->faker->word(),
            'observaciones' => $this->faker->text(),
            'incidenceable_id' => $this->faker->numberBetween(1,1000),
            'incidenceable_type' => $this->faker->randomElement(['App\Models\CatastroArchivo', 'App\Models\RppArchivo']),
        ];
    }
}
