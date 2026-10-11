<?php

declare(strict_types=1);

namespace App\Policies\Employee;

use App\Models\Qualifications\Qualification;
use App\Models\User;

class QualificationPolicy
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
    public function view(User $user, Qualification $qualification): bool
    {
        return $user->can('view-qualification')
            || $user->employee?->id === $qualification->employee_id;
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
    public function update(User $user, Qualification $qualification): bool
    {
        return $user->can('update-qualification')
            || $user->employee?->id === $qualification->employee_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Qualification $qualification): bool
    {
        return $user->can('delete-qualification')
            || $qualification->employee_id === $user->employee?->id;
    }
}
