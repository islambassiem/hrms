<?php

declare(strict_types=1);

namespace App\Policies\Employee;

use App\Models\Request\Letter;
use App\Models\User;

class LetterPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Letter $letter): bool
    {
        return $user->can('view-letter')
            || $user->employee?->id === $letter->employee_id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Letter $letter): bool
    {
        return $user->can('update-letter')
            || $user->employee?->id === $letter->employee_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Letter $letter): bool
    {
        return $user->can('delete-letter')
            || $user->employee?->id === $letter->employee_id;
    }
}
