<?php

namespace App\Queries\Qualification;

use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EmployeeQualificationsQuery
{
    public function run(?Employee $employee = null): Builder
    {
        return Qualification::query()
            ->when(
                $employee,
                fn (Builder $query) => $query->where('employee_id', $employee?->id),
                fn (Builder $query): Builder => $query,
            );
    }
}
