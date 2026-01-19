<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateInstitutionCategoryRequest;
use App\Http\Requests\Web\UpdateInstitutionCategoryRequest;
use App\Models\InstitutionCategory;
use App\Services\InstitutionCategoryService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitutionCategoryController extends Controller
{

    public function __construct(
        private InstitutionCategoryService $service
    ) {
    }


    public function index()
    {
        return Inertia::render(
            'institution/category/Index',
            [
                'categories' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('institution/category/Create');
    }

    public function store(CreateInstitutionCategoryRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('category.index')
            ->with('success', 'Categoria criada com sucesso');
    }

    public function edit(InstitutionCategory $category)
    {
        return Inertia::render(
            'institution/category/Edit',
            [
                'category' => $category,
            ]
        );
    }

     public function update(UpdateInstitutionCategoryRequest $request, InstitutionCategory $category)
    {
        $category->update($request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(InstitutionCategory $category)
    {
        $this->service->remove($category);

        return redirect()->back()->with('success', 'Removido');
    }
}
