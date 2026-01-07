<?php

namespace App\Services;

use App\Models\CategoriaInstituicao;

class CategoriaInstituicaoService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function listar()
    {
        return CategoriaInstituicao::orderBy('nome')->get();
    }

    public function criar(array $dados)
    {
        return CategoriaInstituicao::create($dados);
    }

    public function atualizar(CategoriaInstituicao $categoria, array $dados)
    {
        $categoria->update($dados);
        return $categoria;
    }

    public function remover(CategoriaInstituicao $categoria)
    {
        $categoria->delete();
    }
}
