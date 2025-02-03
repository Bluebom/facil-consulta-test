<?php

/**
    Para listar todos os médicos cadastrados, deve ser feito uma requisição GET para
    o endpoint /medicos .
    Também deverá ser possível buscar por parte do nome do médico através do
    parâmetro nome na URL. Neste filtro, deverá ser desconsiderado a procura por
    prefixo como "dr” e "dra
    A ordenação dos resultados deverá ser em ordem alfabética.
    O retorno esperado é um Array de objetos JSON do tipo Medico.
*/

use App\Models\Cidade;
use App\Models\Consulta;
use App\Models\Medico;
use App\Models\Paciente;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

it('has medicos list', function () {
    $response = $this->get('/medicos');

    $response->assertStatus(200);
});

it('has medicos list with name filter', function () {
    $nome = 'Dr. João da Silva';
    $medico = Medico::factory()->create(['nome' => $nome]);
    $response = $this->get('/medicos?nome='.$nome);

    $response->assertStatus(200);
    expect($response->content())->toBeJson();
    expect($response->content())->toHaveAttribute('nome', $nome);
    $total = Medico::query()->where(function($query) use($nome) {
        return $this->insensitiveUnaccentedSearch($query, 'nome', $nome);
    })->count();
    expect($response->json())->toHaveCount($total);
});

/**
    Para agendar uma consulta, deverá ser feito uma requisição POST para o endpoint
    /medicos/consulta .
    No body da requisição deverá conter os parâmetros medico_id (com o ID do
    médico), paciente_id (com o ID do paciente) e a data da consulta no formato
    timestamp (Y-m-d H:i:s)
    Este recurso só deve estar disponível para usuários autenticados.
    O retorno esperado é a model Consulta criada. 
*/

it("schedule a consulta", function () {
    $user = User::factory()->create();
    $token = auth()->tokenById($user->id);

    $medico = Medico::factory()->create();
    $paciente = Paciente::factory()->create();
    $data = now()->addDay()->format('Y-m-d H:i:s');
    $response = $this->post('/medicos/consulta', [
        'medico_id' => $medico->id,
        'paciente_id' => $paciente->id,
        'data' => $data,
    ], ['Authorization' => 'Bearer '.$token]);

    $response->assertStatus(201);
    $response->assertJsonStructure(['id', 'medico_id', 'paciente_id', 'data']);
    $response->assertJson(['medico_id' => $medico->id, 'paciente_id' => $paciente->id, 'data' => $data]);
});

/**
    Este é o endpoint responsável por retornar todos os pacientes que possuem
    consultas agendadas e/ou realizadas com o médico. Apenas usuários
    autenticados tem autorização para acessar esta rota.
    Deverá ser feito uma requisição do tipo GET para o endpoint
    /medicos/{id_medico}/pacientes .
    Este endpoint deve contar com um parâmetro opcional chamado apenas-agendadas
    que será um boolean. Se o parâmetro existir e for true , deverá retornar apenas
    consultas que ainda não foram realizadas.
    Também deverá ser possível buscar por parte do nome do paciente através do
    parâmetro nome na URL.
    A ordenação dos resultados deverá ser por ordem crescente da data da consulta.
    E o retorno esperado é um array de objetos do tipo Paciente com a relação da
    model Consulta.
*/

it("has pacientes list by medico", function () {
    $user = User::factory()->create();
    $token = auth()->tokenById($user->id);

    $consulta = Consulta::factory()->create();
    $response = $this->get('/medicos/'.$consulta->medico_id.'/pacientes', ['Authorization' => 'Bearer '.$token]);

    $response->assertStatus(200);
});

it("has pacientes list by medico with only scheduled", function () {
    $user = User::factory()->create();
    $token = auth()->tokenById($user->id);

    $consulta = Consulta::factory()->create();
    $response = $this->get('/medicos/'.$consulta->medico_id.'/pacientes?apenas-agendadas=true', ['Authorization' => 'Bearer '.$token]);

    $response->assertStatus(200);
});

/**
    Este é o endpoint responsável por adicionar novos médicos
*/

it("create medico", function () {
    $user = User::factory()->create();
    $token = auth()->tokenById($user->id);

    $faker = \Faker\Factory::create('pt_BR');
    $nome = $faker->name;
    $cidade = Cidade::factory()->create();
    $response = $this->post('/medicos', [
        'nome' => $nome,
        'especialidade' => $faker->randomElement(['Cardiologista', 'Ortopedista', 'Pediatra', 'Clínico Geral']),
        'cidade_id' => $cidade->id,
    ], ['Authorization' => 'Bearer '.$token]);

    $response->assertStatus(201);
    expect(Medico::query()->where('nome', $nome)->exists())->toBeTrue();
});