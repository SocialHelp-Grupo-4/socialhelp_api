<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Services\InstitutionContext;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InstitutionContextController extends Controller
{
    public function __construct(protected InstitutionContext $context)
    {
    }

    public function index(Request $request)
    {
        $institutions = $request->user()->institutions;
        return response()->json([
            'data' => $institutions,
            'current_institution_id' => $this->context->id()
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'institution_id' => 'required|exists:institutions,id'
        ]);

        $user = $request->user();

        // Verify user belongs to this institution
        if (!$user->institutions()->where('institutions.id', $request->institution_id)->exists()) {
            return response()->json(['message' => 'Unauthorized access to this institution.'], 403);
        }

        $this->context->set($request->institution_id);

        return response()->json(['message' => 'Institution context switched successfully.']);
    }

    public function current()
    {
        return response()->json(['data' => $this->context->get()]);
    }
}
