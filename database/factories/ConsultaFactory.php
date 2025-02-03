<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Consulta>
 */
class ConsultaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $medico = \App\Models\Medico::factory()->create();
        $paciente = \App\Models\Paciente::factory()->create();
        return [
            'data' => $this->faker->dateTimeThisYear->format('Y-m-d H:i:s'),
            'medico_id' => $medico->id,
            'paciente_id' => $paciente->id,
        ];
    }
}
