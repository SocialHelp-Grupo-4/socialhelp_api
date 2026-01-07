<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\CategoriaInstituicao\CreateCategoriaInstituicaoRequest;
use App\Http\Requests\Api\V1\CategoriaInstituicao\UpdateCategoriaInstituicaoRequest;
use App\Http\Resources\CategoriaInstituicaoResource;
use App\Models\CategoriaInstituicao;
use App\Services\CategoriaInstituicaoService;
use Illuminate\Http\Request;

class CategoriaInstituicaoController extends Controller
{

    public function __construct(
        private CategoriaInstituicaoService $service
    ) {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return CategoriaInstituicaoResource::collection(
            $this->service->listar()
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(CreateCategoriaInstituicaoRequest $request)
    {
        return new CategoriaInstituicaoResource(
            $this->service->criar($request->validated())
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoriaInstituicaoRequest $request, CategoriaInstituicao $categoriaInstituicao)
    {
        return new CategoriaInstituicaoResource(
            $this->service->atualizar($categoriaInstituicao, $request->validated())
        );
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CategoriaInstituicao $categoriaInstituicao)
    {
        $this->service->remover($categoriaInstituicao);
        return response()->json(['message' => 'Categoria removida']);
    }
}
