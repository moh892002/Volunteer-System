<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Volunteer;

class VolunteerPolicy
{
    /**
     * Determine if the user can view any volunteers.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view volunteers
        return true;
    }

    /**
     * Determine if the user can view the volunteer.
     */
    public function view(User $user, Volunteer $volunteer): bool
    {
        // All authenticated users can view a volunteer
        return true;
    }

    /**
     * Determine if the user can create volunteers.
     */
    public function create(User $user): bool
    {
        // Both admin and regular users can create volunteers
        return $user->isAdmin() || $user->isUser();
    }

    /**
     * Determine if the user can update the volunteer.
     */
    public function update(User $user, Volunteer $volunteer): bool
    {
        // Only admins can update volunteers
        return $user->isAdmin();
    }

    /**
     * Determine if the user can delete the volunteer.
     */
    public function delete(User $user, Volunteer $volunteer): bool
    {
        // Only admins can delete volunteers
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the volunteer.
     */
    public function restore(User $user, Volunteer $volunteer): bool
    {
        // Only admins can restore volunteers
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the volunteer.
     */
    public function forceDelete(User $user, Volunteer $volunteer): bool
    {
        // Only admins can force delete volunteers
        return $user->isAdmin();
    }
}
