<?php

namespace Database\Factories;

use App\Http\Constantes;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RppArchivo>
 */
class RppArchivoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'tomo' => $this->faker->randomNumber,
            'tomo_bis' => $this->faker->randomNumber,
            'seccion' => $this->faker->randomElement(Constantes::SECCIONES),
            'distrito' => $this->faker->numberBetween(1,19),
            'estado' => $this->faker->randomElement(['disponible', 'ocupado']),
        ];
    }
}
