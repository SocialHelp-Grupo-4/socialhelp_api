<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\Web\CreateProjectRequest;
use App\Http\Requests\Web\UpdateProjectRequest;
use App\Models\Project;
use App\Services\ProjectService;
use App\Services\InstitutionService;
use App\Services\ProblemAreaService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Enums\Enums\ProjectStatus;

class ProjectController extends Controller
{
    public function __construct(
        private ProjectService $service,
        private InstitutionService $institutionService,
        private ProblemAreaService $problemAreaService
    ) {
    }

    public function index()
    {
        return Inertia::render(
            'project/Index',
            [
                'projects' => $this->service->index(),
            ]
        );
    }

    public function create()
    {
        return Inertia::render('project/Create', [
            'institutions' => $this->institutionService->index(),
            'problemAreas' => $this->problemAreaService->index(),
            'statuses' => ProjectStatus::cases(),
        ]);
    }

    public function store(CreateProjectRequest $request)
    {
        $this->service->create($request->validated());

        return redirect()
            ->route('project.index')
            ->with('success', 'Projecto criado com sucesso');
    }

    public function edit(Project $project)
    {
        $project->load('problemAreas');
        return Inertia::render(
            'project/Edit',
            [
                'project' => $project,
                'institutions' => $this->institutionService->index(),
                'problemAreas' => $this->problemAreaService->index(),
                'statuses' => ProjectStatus::cases(),
            ]
        );
    }

    public function update(UpdateProjectRequest $request, Project $project)
    {
        $this->service->update($project, $request->validated());

        return redirect()->back()->with('success', 'Atualizado');
    }

    public function destroy(Project $project)
    {
        $this->service->remove($project);

        return redirect()->back()->with('success', 'Removido');
    }
}
