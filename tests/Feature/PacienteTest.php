<?php

/**
    Este endpoint será utilizado para alterar os dados de um paciente específico.
    Apenas usuários autenticados tem autorização para acessar esta rota.
    Somente o nome e o celular podem ser alterados.
    Este recurso será acessado através da rota /pacientes/{id_paciente} com o método
    POST .
    O retorno esperado é os dados do paciente atualizados em formato de objeto
    JSON.
 */

use App\Models\Paciente;
use App\Models\User;

it('update paciente', function () {
    $user = User::factory()->create();
    $token = auth()->tokenById($user->id);

    $faker = \Faker\Factory::create('pt_BR');
    $paciente = Paciente::factory()->create();
    $response = $this->put('pacientes/' . $paciente->id,
        [
            'nome' => $faker->name,
            'celular' => $faker->cellphoneNumber(true),
        ],
        ['Authorization' => 'Bearer ' . $token]
    );

    $response->assertStatus(200);
});

/**
    Este é o endpoint responsável por adicionar um novo paciente à base de dados.
    Apenas usuários autenticados tem autorização para acessar esta rota.
    Deverá ser feito uma requisição do tipo POST para o endpoint /pacientes .
    O retorno esperado é os dados do novo paciente em formato de objeto JSON.
*/

it('create paciente', function () {
    $user = User::factory()->create();
    $token = auth()->tokenById($user->id);

    $faker = \Faker\Factory::create('pt_BR');
    $nome = $faker->name;
    $cpf = $faker->cpf(true);
    $celular = $faker->cellphoneNumber(true);
    $response = $this->post('pacientes',
        [
            'nome' => $nome,
            'cpf' => $cpf,
            'celular' => $celular,
        ],
        ['Authorization' => 'Bearer ' . $token]
    );

    $response->assertStatus(201);
    expect(Paciente::query()->where('cpf', $cpf)->exists())->toBeTrue();
});