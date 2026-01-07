<?php

namespace App\Http\Controllers;

use App\Http\Requests\Api\V1\CategoriaInstituicao\CreateCategoriaInstituicaoRequest;
use App\Http\Requests\Api\V1\CategoriaInstituicao\UpdateCategoriaInstituicaoRequest;
use App\Models\CategoriaInstituicao;
use App\Services\CategoriaInstituicaoService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoriaInstituicaoController extends Controller
{

    public function __construct(
        private CategoriaInstituicaoService $service
    ) {
    }


    public function index()
    {
        return Inertia::render(
            'categorias-instituicao/Index',
            [
                'categorias' => $this->service->listar(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('categorias-instituicao/Create');
    }

    public function store(CreateCategoriaInstituicaoRequest $request)
    {
        $this->service->criar($request->validated());

        return redirect()
            ->route('categorias-instituicao.index')
            ->with('success', 'Categoria criada com sucesso');
    }

    public function edit(CategoriaInstituicao $categoriaInstituicao)
    {
        return Inertia::render(
            'categorias-instituicao/Edit',
            [
                'categoria' => $categoriaInstituicao,
            ]
        );
    }

     public function update(UpdateCategoriaInstituicaoRequest $request, CategoriaInstituicao $categoriaInstituicao)
    {
        $categoriaInstituicao->update($request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(CategoriaInstituicao $categoriaInstituicao)
    {
        $this->service->remover($categoriaInstituicao);

        return redirect()->back()->with('success', 'Removido');
    }
}
