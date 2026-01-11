<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Assignment;

class AssignmentPolicy
{
    /**
     * Determine if the user can view any assignments.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view assignments
        return true;
    }

    /**
     * Determine if the user can view the assignment.
     */
    public function view(User $user, Assignment $assignment): bool
    {
        // All authenticated users can view an assignment
        return true;
    }

    /**
     * Determine if the user can create assignments.
     */
    public function create(User $user): bool
    {
        // Both admin and regular users can create assignments
        return $user->isAdmin() || $user->isUser();
    }

    /**
     * Determine if the user can update the assignment.
     */
    public function update(User $user, Assignment $assignment): bool
    {
        // Both admin and regular users can update assignments
        return $user->isAdmin() || $user->isUser();
    }

    /**
     * Determine if the user can delete the assignment.
     */
    public function delete(User $user, Assignment $assignment): bool
    {
        // Only admins can delete assignments
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the assignment.
     */
    public function restore(User $user, Assignment $assignment): bool
    {
        // Only admins can restore assignments
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the assignment.
     */
    public function forceDelete(User $user, Assignment $assignment): bool
    {
        // Only admins can force delete assignments
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update assignment status.
     */
    public function updateStatus(User $user, Assignment $assignment): bool
    {
        // Both admin and regular users can update assignment status
        return $user->isAdmin() || $user->isUser();
    }
}
