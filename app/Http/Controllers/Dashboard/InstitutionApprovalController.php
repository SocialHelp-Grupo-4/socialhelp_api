<?php

namespace App\Http\Controllers\Dashboard;

use App\Enums\Enums\InstitutionStatus;
use App\Http\Controllers\Controller;
use App\Models\Institution;
use App\Mail\InstitutionApproved;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;
use Log;

class InstitutionApprovalController extends Controller
{
    /**
     * List pending institutions.
     */
    public function index()
    {
        // Ideally this should be protected by a 'super-admin' middleware
        // For now, assuming any logged-in user with access to this route is an admin
        // or we filter based on a specific system-wide role.

        $pendingInstitutions = Institution::where('status', InstitutionStatus::PENDING)
            ->with(['category', 'users']) // eager load owner?
            ->orderByDesc('created_at')
            ->get();

        return Inertia::render('Admin/InstitutionApprovals/Index', [
            'institutions' => $pendingInstitutions
        ]);
    }

    /**
     * Approve an institution.
     */
    public function approve(Institution $institution)
    {
        try {
            if ($institution->status === InstitutionStatus::APPROVED) {
                return back()->with('info', 'Instituição já aprovada.');
            }

            $institution->update(['status' => InstitutionStatus::APPROVED]);

            // Notify Owner
            // Assuming the creator (user_id) or the first admin user is the owner to notify
            // $owner = $institution->users()->wherePivot('role', 'admin')->first(); 
            // Or simply the creator:
            $owner = \App\Models\User::find($institution->user_id);

            if ($owner) {
                Mail::to($owner->email)->send(new InstitutionApproved($institution, $owner));
            }

            return back()->with('success', 'Instituição aprovada e notificação enviada.');
        } catch (\Throwable $th) {
            Log::error($th->getMessage());
            return back()->with('error', 'Erro ao aprovar instituição: ' . $th->getMessage());
        }
    }

    /**
     * Reject an institution.
     */
    public function reject(Institution $institution)
    {
        // Optional: Add reason
        $institution->update(['status' => InstitutionStatus::REJECTED]); // Or delete?

        return back()->with('success', 'Instituição rejeitada.');
    }
}
