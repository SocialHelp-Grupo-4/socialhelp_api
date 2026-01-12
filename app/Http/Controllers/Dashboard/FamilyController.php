<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateFamilyRequest;
use App\Http\Requests\Web\UpdateFamilyRequest;
use App\Models\Family;
use App\Services\FamilyService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class FamilyController extends Controller
{

    public function __construct(
        private FamilyService $service
    ) {
    }


    public function index()
    {
        return Inertia::render(
            'family/Index',
            [
                'families' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('family/Create');
    }

    public function store(CreateFamilyRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('family.index')
            ->with('success', 'Família criada com sucesso');
    }

    public function edit(Family $family)
    {
        return Inertia::render(
            'family/Edit',
            [
                'family' => $family,
            ]
        );
    }

     public function update(UpdateFamilyRequest $request, Family $family)
    {
        $family->update($request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(Family $family)
    {
        $this->service->remove($family);

        return redirect()->back()->with('success', 'Removido');
    }
}
