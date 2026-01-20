<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\InstitutionContext;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class InstitutionMembersController extends Controller
{
    public function __construct(protected InstitutionContext $context)
    {
    }

    public function index()
    {
        $institution = $this->context->get();
        abort_if(!$institution, 403, 'Context missing');

        $members = $institution->users()
            ->orderBy('name')
            ->paginate(20)
            ->through(fn($user) => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $user->pivot->role,
                'joined_at' => $user->pivot->created_at->format('d/m/Y'),
            ]);

        return Inertia::render('Institution/Members/Index', [
            'members' => $members
        ]);
    }

    public function update(Request $request, $userId)
    {
        $institution = $this->context->get();
        abort_if(!$institution, 403);

        $request->validate(['role' => 'required|string']);

        $institution->users()->updateExistingPivot($userId, ['role' => $request->role]);

        return back()->with('success', 'Função do membro atualizada.');
    }

    public function destroy($userId)
    {
        $institution = $this->context->get();
        abort_if(!$institution, 403);

        if ($userId === auth()->id()) {
            return back()->withErrors(['message' => 'Você não pode se remover.']);
        }

        $institution->users()->detach($userId);

        return back()->with('success', 'Membro removido da instituição.');
    }
}
