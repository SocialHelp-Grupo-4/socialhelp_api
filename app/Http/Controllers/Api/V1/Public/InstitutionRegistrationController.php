<?php

namespace App\Http\Controllers\Api\V1\Public;

use App\Enums\Enums\InstitutionStatus;
use App\Http\Controllers\Controller;
use App\Models\Institution;
use DB;
use Log;
use Illuminate\Http\Request;

class InstitutionRegistrationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nif' => 'required|string|unique:institutions,nif',
            'email' => 'required|email|unique:institutions,email',
            'institution_category_id' => 'required|exists:institution_categories,id',
            'description' => 'nullable|string'
        ], [
            'institution_category_id.exists' => 'A categoria selecionada é inválida.',
            'nif.unique' => 'Já existe uma instituição registada com este NIF.',
            'name.required' => 'O campo nome é obrigatório.',
            'nif.required' => 'O campo NIF é obrigatório.',
            'email.required' => 'O campo email é obrigatório.',
            'email.email' => 'O campo email deve ser um endereço de email válido.',
            'email.unique' => 'Já existe uma instituição registada com este email.'
        ]);
        try {

            DB::beginTransaction();

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
                'role' => 'Gestor', // Owner/Admin
                'is_active' => true // Pending approval global institution, but active locally? Or check status?
            ]);

            // Assign Spatie Role
            setPermissionsTeamId($institution->id);
            $user->assignRole('Gestor');

            DB::commit();

            return response()->json([
                'message' => 'Instituição registada com sucesso! Aguarde a aprovação do administrador.',
                'data' => $institution
            ], 201);
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Institution Registration Failed: ' . $th->getMessage());
            return response()->json(['error' => 'Registo da instituição falhou', 'details' => $th->getMessage()], 500);
        }
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
