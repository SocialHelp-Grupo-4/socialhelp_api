<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\InstitutionInvitation;
use App\Models\User;
use App\Services\InstitutionContext;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class InstitutionInvitationController extends Controller
{
    public function __construct(protected InstitutionContext $context)
    {
    }

    public function index()
    {
        $institution = $this->context->get();
        abort_if(!$institution, 403, 'Context missing');

        $invitations = $institution->invitations()->orderByDesc('created_at')->paginate(20);

        return Inertia::render('Institution/Invitations/Index', [
            'invitations' => $invitations
        ]);
    }

    public function store(Request $request)
    {
        $institution = $this->context->get();
        abort_if(!$institution, 403, 'Context missing');

        $request->validate([
            'email' => 'required|email|unique:institution_invitations,email,NULL,id,institution_id,' . $institution->id,
            'role' => 'required|string'
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user) {
            // User exists, attach directly if not already member
            if ($institution->users()->where('user_id', $user->id)->exists()) {
                return back()->withErrors(['email' => 'Utilizador já é membro desta instituição.']);
            }

            $institution->users()->attach($user->id, [
                'role' => $request->role,
                'is_active' => true
            ]);

            // Assign Spatie Role
            setPermissionsTeamId($institution->id);
            $user->assignRole($request->role);

            return back()->with('success', 'Utilizador adicionado diretamente à instituição.');
        }

        // User does not exist, create invitation
        $invitation = $institution->invitations()->create([
            'email' => $request->email,
            'role' => $request->role,
            'token' => Str::random(32),
            'status' => 'pending'
        ]);

        // TODO: Send Email Notification logic here (Mailable)

        return back()->with('success', 'Convite enviado com sucesso.');
    }

    public function destroy($id)
    {
        $institution = $this->context->get();
        $invitation = $institution->invitations()->findOrFail($id);

        $invitation->delete();

        return back()->with('success', 'Convite removido.');
    }
}
