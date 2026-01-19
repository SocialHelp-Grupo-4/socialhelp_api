<?php

namespace App\Services;

use App\Models\Project;

class ProjectService
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {

    }

    public function index()
    {
        return Project::with(['institution', 'problemAreas'])->orderBy('name')->get();
    }

    public function paginate(int $perPage = 15)
    {
        return Project::with(['institution', 'problemAreas'])->orderBy('name')->paginate($perPage);
    }

    public function create(array $data)
    {
        $project = Project::create($data);
        if (isset($data['problem_areas'])) {
            $project->problemAreas()->sync($data['problem_areas']);
        }
        return $project;
    }

    public function update(Project $project, array $data)
    {
        $project->update($data);
        if (isset($data['problem_areas'])) {
            $project->problemAreas()->sync($data['problem_areas']);
        }
        return $project;
    }

    public function remove(Project $project)
    {
        $project->delete();
    }
}
