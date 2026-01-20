<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        // List active projects. Could filter by institution if passed.
        $query = Project::query();

        if ($request->has('institution_id')) {
            $query->where('institution_id', $request->institution_id);
        }

        // Add scopeActive() to Project model later if needed
        $projects = $query->paginate(20);

        return response()->json($projects);
    }

    public function show($id)
    {
        $project = Project::with(['institution', 'areaProblema'])->findOrFail($id);
        return response()->json($project);
    }

    public function register(Request $request, $id)
    {
        $project = Project::findOrFail($id);
        $user = $request->user();

        // Check availability, etc.
        // Needs a pivot table `project_user` or `applications` table.
        // For now, assuming standard logic implies creating an application.
        // Changing to a simple success message as placeholder for "Application Logic".

        return response()->json(['message' => 'Application submitted successfully (Mock).']);
    }
}
