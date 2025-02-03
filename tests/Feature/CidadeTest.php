<?php

use App\Models\Cidade;
use App\Models\Medico;

/**
    Para listar as cidades cadastradas, deve ser feito uma requisição GET para o
    endpoint /cidades e não é necessário estar autenticado.
    Também deverá ser possível buscar por parte do nome da cidade através do
    parâmetro nome na URL.
    A ordenação dos resultados deverá ser em ordem alfabética.
    O retorno esperado é um Array de objetos JSON do tipo Cidade.
*/

it('has cidades list', function () {
    $response = $this->get('/cidades');
    $response->assertStatus(200);
});

it('has cidades list with name filter', function () {
    Cidade::factory()->create(['nome' => 'Porto Alegre', 'estado' => 'RS']);
    $nome = 'Porto';
    $response = $this->get('/cidades?nome='.$nome);

    $response->assertStatus(200);
    expect($response->content())->toBeJson();
    expect($response->content())->toHaveAttribute('nome', 'Porto Alegre');
    $total = Cidade::query()->where(function($query) use($nome) {
        return $this->insensitiveUnaccentedSearch($query, 'nome', $nome);
    })->count();
    expect($response->json())->toHaveCount($total);
});

/**
    Para listar apenas os médicos de uma cidade específica, deverá ser feito uma
    requisição GET para o endpoint /cidades/{id_cidade}/medicos .
    Também deverá ser possível buscar por parte do nome do médico através do
    parâmetro nome na URL. Neste filtro, deverá ser desconsiderado a procura por
    prefixo como "dr” e "dra
    A ordenação dos resultados deverá ser em ordem alfabética.
    O retorno esperado é um Array de objetos do tipo Medico.
*/

it('has medicos list by cidade', function () {
    $medico = Medico::factory()->create();
    $cidadeId = $medico->cidade_id;
    Medico::factory()->count(10)->create(['cidade_id' => $cidadeId]);
    $response = $this->get('/cidades/'.$cidadeId.'/medicos');
    $response->assertStatus(200);
});