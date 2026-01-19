<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateProblemAreaRequest;
use App\Http\Requests\Web\UpdateProblemAreaRequest;
use App\Models\ProblemArea;
use App\Services\ProblemAreaService;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProblemAreaController extends Controller
{
    public function __construct(
        private ProblemAreaService $service
    ) {
    }

    public function index()
    {
        return Inertia::render(
            'problem_area/Index',
            [
                'problemAreas' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('problem_area/Create');
    }

    public function store(CreateProblemAreaRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('problem_area.index')
            ->with('success', 'Área de problema criada com sucesso');
    }

    public function edit(ProblemArea $problemArea)
    {
        return Inertia::render(
            'problem_area/Edit',
            [
                'problemArea' => $problemArea,
            ]
        );
    }

    public function update(UpdateProblemAreaRequest $request, ProblemArea $problemArea)
    {
        $this->service->update($problemArea, $request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(ProblemArea $problemArea)
    {
        $this->service->remove($problemArea);

        return redirect()->back()->with('success', 'Removido');
    }
}
