<?php

namespace App\Http\Controllers;

use App\Http\Requests\ConsultaRequest;
use App\Http\Requests\StoreMedicoRequest;
use App\Http\Traits\SearchTrait;
use App\Models\Consulta;
use App\Models\Medico;
use App\Models\Paciente;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MedicoController extends Controller
{
    use SearchTrait;

    public function index(Request $request)
    {
        $nome = $request->get('nome');
        $medicos = Medico::query()->when($nome, fn($query) => $this->insensitiveUnaccentedSearch($query, 'nome', $nome))->orderBy('nome')->get();
        return response()->json($medicos);
    }

    public function consulta(ConsultaRequest $request) {
        $consulta = Consulta::query()->create($request->only(['medico_id', 'paciente_id', 'data']));
        if(!$consulta) {
            return response()->json(['errors' => ['Erro ao criar consulta']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($consulta, Response::HTTP_CREATED);
    }

    public function pacientes(Request $request, int $id)
    {
        $medico = Medico::query()->find($id);
        if(!$medico) {
            return response()->json(['errors' => ['Médico não encontrado']], Response::HTTP_NOT_FOUND);
        }
        $apenasAgendadas = $request->get('apenas-agendadas');
        $pacientes = Paciente::query()->with('consultas')->whereHas('consultas', function($aQuery) use($id, $apenasAgendadas) {
            return $aQuery->where('medico_id', $id)->when($apenasAgendadas, fn($bQuery) => $bQuery->where('data', '>', now()));
        })->orderBy('nome')->get();
        return response()->json($pacientes);
    }

    public function store(StoreMedicoRequest $request)
    {
        $medico = Medico::query()->create($request->only(['nome', 'especialidade', 'cidade_id']));
        if(!$medico) {
            return response()->json(['errors' => ['Erro ao criar médico']], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
        return response()->json($medico, Response::HTTP_CREATED);
    }
}
