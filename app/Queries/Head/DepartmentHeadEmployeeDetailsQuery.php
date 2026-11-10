<?php

declare(strict_types=1);

namespace App\Queries\Head;

use App\Models\Employee\Employee;
use Illuminate\Database\Eloquent\Builder;

final class DepartmentHeadEmployeeDetailsQuery
{
    /**
     * @return Builder<Employee>
     */
    public function run(Employee $departmentHead, int $employeeId): Builder
    {
        return Employee::query()
            ->with([
                'user:id,email',
                'gender',
                'department',
                'latestCurrentJobTitle.jobTitle',
            ])
            ->whereKey($employeeId)
            ->where('head_id', $departmentHead->id)
            ->where('is_active', true);
    }
}
