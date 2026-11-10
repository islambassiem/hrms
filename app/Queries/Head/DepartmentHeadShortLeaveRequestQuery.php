<?php

declare(strict_types=1);

namespace App\Queries\Head;

use App\Data\Head\DepartmentHeadShortLeaveFiltersData;
use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final class DepartmentHeadShortLeaveRequestQuery
{
    /**
     * @return Builder<ShortLeaveRequest>
     */
    public function run(
        Employee $departmentHead,
        DepartmentHeadShortLeaveFiltersData $filters,
    ): Builder {
        return ShortLeaveRequest::query()
            ->with(['employee', 'shortLeaveType'])
            ->whereHas('employee', fn (Builder $query): Builder => $query
                ->where('head_id', $departmentHead->id)
                ->where('is_active', true))
            ->when(
                $filters->employeeId,
                fn (Builder $query, int $employeeId): Builder => $query->where('employee_id', $employeeId),
            )
            ->when(
                $filters->shortLeaveTypeId,
                fn (Builder $query, int $shortLeaveTypeId): Builder => $query->where(
                    'short_leave_type_id',
                    $shortLeaveTypeId,
                ),
            )
            ->when(
                $filters->status,
                fn (Builder $query, string $status): Builder => $query->where('status', $status),
            )
            ->when(
                $filters->fromDate,
                fn (Builder $query, CarbonImmutable $fromDate): Builder => $query->whereDate(
                    'short_leave_date',
                    '>=',
                    $fromDate,
                ),
            )
            ->when(
                $filters->toDate,
                fn (Builder $query, CarbonImmutable $toDate): Builder => $query->whereDate(
                    'short_leave_date',
                    '<=',
                    $toDate,
                ),
            )
            ->latest();
    }

    /**
     * @return Builder<ShortLeaveType>
     */
    public function shortLeaveTypes(): Builder
    {
        return ShortLeaveType::query()
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
