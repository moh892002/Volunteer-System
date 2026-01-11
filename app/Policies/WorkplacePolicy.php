<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Workplace;

class WorkplacePolicy
{
    /**
     * Determine if the user can view any workplaces.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view workplaces
        return true;
    }

    /**
     * Determine if the user can view the workplace.
     */
    public function view(User $user, Workplace $workplace): bool
    {
        // All authenticated users can view a workplace
        return true;
    }

    /**
     * Determine if the user can create workplaces.
     */
    public function create(User $user): bool
    {
        // Both admin and regular users can create workplaces
        return $user->isAdmin() || $user->isUser();
    }

    /**
     * Determine if the user can update the workplace.
     */
    public function update(User $user, Workplace $workplace): bool
    {
        // Both admin and regular users can update workplaces
        return $user->isAdmin() || $user->isUser();
    }

    /**
     * Determine if the user can delete the workplace.
     */
    public function delete(User $user, Workplace $workplace): bool
    {
        // Only admins can delete workplaces
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the workplace.
     */
    public function restore(User $user, Workplace $workplace): bool
    {
        // Only admins can restore workplaces
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the workplace.
     */
    public function forceDelete(User $user, Workplace $workplace): bool
    {
        // Only admins can force delete workplaces
        return $user->isAdmin();
    }
}
