<?php

namespace App\Services;

use App\Models\Institution;
use Illuminate\Support\Facades\Session;

class InstitutionContext
{
    protected const SESSION_KEY = 'active_institution_id';

    /**
     * Set the current active institution.
     */
    public function set(int $institutionId): void
    {
        Session::put(self::SESSION_KEY, $institutionId);
    }

    /**
     * Get the current active institution ID.
     */
    public function id(): ?int
    {
        return Session::get(self::SESSION_KEY);
    }

    /**
     * Get the current active institution Model.
     */
    public function get(): ?Institution
    {
        $id = $this->id();

        if (!$id) {
            return null;
        }

        return Institution::find($id);
    }

    /**
     * Check if an institution is selected.
     */
    public function check(): bool
    {
        return Session::has(self::SESSION_KEY);
    }

    /**
     * Clear the current context.
     */
    public function clear(): void
    {
        Session::forget(self::SESSION_KEY);
    }
}
