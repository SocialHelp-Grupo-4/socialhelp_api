<?php

namespace App\Services;

use App\Models\InstitutionInvitation;
use App\Models\User;

class InvitationService
{
    /**
     * Process any pending invitations for the given user email.
     */
    public function processPendingFor(User $user)
    {
        $invitations = InstitutionInvitation::where('email', $user->email)
            ->where('status', 'pending')
            ->get();

        foreach ($invitations as $invitation) {
            // Attach to Institution
            $institution = $invitation->institution;

            if (!$institution->users()->where('user_id', $user->id)->exists()) {
                $institution->users()->attach($user->id, [
                    'role' => $invitation->role,
                    'is_active' => true
                ]);

                // Assign Spatie Role
                setPermissionsTeamId($institution->id);
                $user->assignRole($invitation->role);
            }

            // Update Invitation
            $invitation->update(['status' => 'accepted']);
        }
    }
}
