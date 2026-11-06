<?php

declare(strict_types=1);

namespace App\Queries\Head;

use App\Data\Head\DepartmentHeadDashboardData;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\Gender;
use App\Models\ShortLeave\ShortLeaveRequest;
use Carbon\CarbonImmutable;

final class DepartmentHeadDashboardQuery
{
    /**
     * @return DepartmentHeadDashboardData The current department's summary.
     */
    public function run(Employee $departmentHead, CarbonImmutable $today): DepartmentHeadDashboardData
    {
        $subordinates = Employee::query()
            ->where('head_id', $departmentHead->id)
            ->where('is_active', true)
            ->get(['id', 'gender_id']);

        $subordinateIds = $subordinates->modelKeys();
        $genderIds = Gender::query()
            ->whereIn('name_en', ['Male', 'Female'])
            ->pluck('id', 'name_en');

        return new DepartmentHeadDashboardData(
            activeStaffCount: $subordinates->count(),
            maleStaffCount: isset($genderIds['Male'])
                ? $subordinates->where('gender_id', $genderIds['Male'])->count()
                : 0,
            femaleStaffCount: isset($genderIds['Female'])
                ? $subordinates->where('gender_id', $genderIds['Female'])->count()
                : 0,
            pendingRegularLeaveCount: LeaveRequest::query()
                ->whereIn('employee_id', $subordinateIds)
                ->where('status', WorkflowActionEnum::PENDING->value)
                ->count(),
            pendingShortLeaveCount: ShortLeaveRequest::query()
                ->whereIn('employee_id', $subordinateIds)
                ->where('status', WorkflowActionEnum::PENDING->value)
                ->count(),
            employeesOnLeaveTodayCount: LeaveRequest::query()
                ->whereIn('employee_id', $subordinateIds)
                ->where('status', WorkflowActionEnum::APPROVED->value)
                ->whereDate('start_date', '<=', $today)
                ->whereDate('end_date', '>=', $today)
                ->distinct()
                ->count('employee_id'),
        );
    }
}
