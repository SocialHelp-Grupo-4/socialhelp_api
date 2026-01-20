<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Enums\Enums\InstitutionStatus;
use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Services\InstitutionContext;
use Illuminate\Http\Request;

class InstitutionRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nif' => 'required|string|unique:institutions,nif',
            'email' => 'required|email',
            'institution_category_id' => 'required|exists:institution_categories,id',
            'description' => 'nullable|string'
        ]);

        $user = $request->user();

        $institution = Institution::create([
            'name' => $request->name,
            'nif' => $request->nif,
            'email' => $request->email,
            'institution_category_id' => $request->institution_category_id,
            'description' => $request->description,
            'user_id' => $user->id, // Created by
            'status' => InstitutionStatus::PENDING
        ]);

        // Attach owner
        $institution->users()->attach($user->id, [
            'role' => 'admin', // Owner/Admin
            'is_active' => true // Pending approval global institution, but active locally? Or check status?
        ]);

        // Assign Spatie Role
        setPermissionsTeamId($institution->id);
        $user->assignRole('admin');

        return response()->json([
            'message' => 'Instituição registada com sucesso! Aguarde a aprovação do administrador.',
            'data' => $institution
        ], 201);
    }

    public function status(Request $request)
    {
        $user = $request->user();
        // Return institutions created by this user and their status
        $institutions = Institution::where('user_id', $user->id)
            ->select('id', 'name', 'status', 'created_at')
            ->get();

        return response()->json($institutions);
    }
}
