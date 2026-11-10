<?php

declare(strict_types=1);

namespace App\Queries\Head;

use App\Data\Head\DepartmentHeadLeaveFiltersData;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\LeaveType;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final class DepartmentHeadLeaveRequestQuery
{
    /**
     * @return Builder<LeaveRequest>
     */
    public function run(Employee $departmentHead, DepartmentHeadLeaveFiltersData $filters): Builder
    {
        return LeaveRequest::query()
            ->with(['employee', 'leaveType'])
            ->whereHas('employee', fn (Builder $query): Builder => $query
                ->where('head_id', $departmentHead->id)
                ->where('is_active', true))
            ->when(
                $filters->employeeId,
                fn (Builder $query, int $employeeId): Builder => $query->where('employee_id', $employeeId),
            )
            ->when(
                $filters->leaveTypeId,
                fn (Builder $query, int $leaveTypeId): Builder => $query->where('leave_type_id', $leaveTypeId),
            )
            ->when(
                $filters->status,
                fn (Builder $query, string $status): Builder => $query->where('status', $status),
            )
            ->when(
                $filters->startDate,
                fn (Builder $query, CarbonImmutable $startDate): Builder => $query->whereDate(
                    'start_date',
                    '>=',
                    $startDate,
                ),
            )
            ->when(
                $filters->endDate,
                fn (Builder $query, CarbonImmutable $endDate): Builder => $query->whereDate(
                    'end_date',
                    '<=',
                    $endDate,
                ),
            )
            ->latest();
    }

    /**
     * @return Builder<Employee>
     */
    public function activeSubordinates(Employee $departmentHead): Builder
    {
        return Employee::query()
            ->where('head_id', $departmentHead->id)
            ->where('is_active', true)
            ->orderBy('employee_code');
    }

    /**
     * @return Builder<LeaveType>
     */
    public function leaveTypes(): Builder
    {
        return LeaveType::query()
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
