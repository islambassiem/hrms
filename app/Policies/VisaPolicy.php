<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Request\Visa;
use App\Models\User;

class VisaPolicy
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
    public function view(User $user, Visa $visa): bool
    {
        return $user->can('view-visa')
            || $user->employee?->id === $visa->employee_id;
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
    public function update(User $user, Visa $visa): bool
    {
        return $user->can('update-visa')
            || $user->employee?->id === $visa->employee_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Visa $visa): bool
    {
        return $user->can('delete-visa')
            || $user->employee?->id === $visa->employee_id;
    }
}
