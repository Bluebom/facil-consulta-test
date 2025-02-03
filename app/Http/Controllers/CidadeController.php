<?php

namespace App\Http\Controllers;

use App\Http\Traits\SearchTrait;
use App\Models\Cidade;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CidadeController extends Controller
{
    use SearchTrait;

    public function index(Request $request)
    {
        $nome = $request->get('nome');
        $cidades = Cidade::query()->when($nome, fn($query) => $this->insensitiveUnaccentedSearch($query, 'nome', $nome))->orderBy('nome')->get();
        return response()->json($cidades);
    }

    public function medicos(int $id)
    {
        $cidade = Cidade::query()->find($id);
        if(!$cidade) {
            return response()->json(['errors' => ['Cidade não encontrada']], Response::HTTP_NOT_FOUND);
        }
        return response()->json($cidade->medicos);
    }
}
