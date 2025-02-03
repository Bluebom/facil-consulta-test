<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Medico>
 */
class MedicoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = \Faker\Factory::create('pt_BR');
        $cidade = \App\Models\Cidade::factory()->create();
        return [
            'nome' => $faker->name,
            'especialidade' => $faker->randomElement(['Cardiologista', 'Ortopedista', 'Pediatra', 'Clínico Geral']),
            'cidade_id' => $cidade->id,
        ];
    }
}
