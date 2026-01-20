<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\InstitutionContext;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitutionSelectionController extends Controller
{
    public function __construct(protected InstitutionContext $context)
    {
    }

    public function index(Request $request)
    {
        $institutions = $request->user()->institutions;

        // If user has only one institution, maybe auto-select? 
        // For now, let's force selection to be explicit or let the frontend decide.

        return Inertia::render('Auth/SelectInstitution', [
            'institutions' => $institutions,
            'current_institution_id' => $this->context->id()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution_id' => 'required|exists:institutions,id'
        ]);

        $user = $request->user();

        if (!$user->institutions()->where('institutions.id', $request->institution_id)->exists()) {
            return back()->withErrors(['institution_id' => 'Invalid institution.']);
        }

        $this->context->set($request->institution_id);

        return to_route('dashboard');
    }
}
