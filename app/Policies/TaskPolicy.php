<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Task;

class TaskPolicy
{
    /**
     * Determine if the user can view any tasks.
     */
    public function viewAny(User $user): bool
    {
        // All authenticated users can view tasks
        return true;
    }

    /**
     * Determine if the user can view the task.
     */
    public function view(User $user, Task $task): bool
    {
        // All authenticated users can view a task
        return true;
    }

    /**
     * Determine if the user can create tasks.
     */
    public function create(User $user): bool
    {
        // Both admin and regular users can create tasks
        return $user->isAdmin();
    }

    /**
     * Determine if the user can update the task.
     */
    public function update(User $user, Task $task): bool
    {
        // Both admin and regular users can update tasks
        return $user->isAdmin();
    }

    /**
     * Determine if the user can delete the task.
     */
    public function delete(User $user, Task $task): bool
    {
        // Only admins can delete tasks
        return $user->isAdmin();
    }

    /**
     * Determine if the user can restore the task.
     */
    public function restore(User $user, Task $task): bool
    {
        // Only admins can restore tasks
        return $user->isAdmin();
    }

    /**
     * Determine if the user can permanently delete the task.
     */
    public function forceDelete(User $user, Task $task): bool
    {
        // Only admins can force delete tasks
        return $user->isAdmin();
    }
}
