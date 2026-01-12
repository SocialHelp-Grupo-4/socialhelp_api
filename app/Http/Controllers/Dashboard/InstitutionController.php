<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateInstitutionRequest;
use App\Http\Requests\Web\UpdateInstitutionRequest;
use App\Models\Institution;
use App\Services\InstitutionService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitutionController extends Controller
{

    public function __construct(
        private InstitutionService $service
    ) {
    }


    public function index()
    {
        return Inertia::render(
            'institution/Index',
            [
                'institutions' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('institution/Create');
    }

    public function store(CreateInstitutionRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('institution.index')
            ->with('success', 'Instituição criada com sucesso');
    }

    public function edit(Institution $institution)
    {
        return Inertia::render(
            'institution/Edit',
            [
                'institution' => $institution,
            ]
        );
    }

     public function update(UpdateInstitutionRequest $request, Institution $institution)
    {
        $institution->update($request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(Institution $institution)
    {
        $this->service->remove($institution);

        return redirect()->back()->with('success', 'Removido');
    }
}
