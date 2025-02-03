<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePacienteRequest;
use App\Http\Requests\UpdatePacienteRequest;
use App\Models\Paciente;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PacienteController extends Controller
{
    public function store(StorePacienteRequest $request)
    {
        $paciente = Paciente::query()->create($request->only(['nome', 'cpf', 'celular']));
        if(!$paciente) {
            return response()->json(['errors' => ['Erro ao criar paciente']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($paciente, Response::HTTP_CREATED);
    }

    public function update(UpdatePacienteRequest $request, int $id)
    {
        $paciente = Paciente::query()->find($id);
        $paciente->nome = $request->get('nome');
        $paciente->celular = $request->get('celular');
        $result = $paciente->save();
        if(!$result) {
            return response()->json(['errors' => ['Erro ao atualizar paciente']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($paciente);
    }
}
