<?php

declare(strict_types=1);

namespace App\Policies\Employee;

use App\Models\Request\FamilyVisit;
use App\Models\User;

class FamilyVisitPolicy
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
    public function view(User $user, FamilyVisit $familyVisit): bool
    {
        return $user->can('view-family-visit')
            || $user->employee?->id === $familyVisit->employee_id;
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
    public function update(User $user, FamilyVisit $familyVisit): bool
    {
        return $user->can('update-family-visit')
            || $user->employee?->id === $familyVisit->employee_id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, FamilyVisit $familyVisit): bool
    {
        return $user->can('delete-family-visit')
            || $user->employee?->id === $familyVisit->employee_id;
    }
}
