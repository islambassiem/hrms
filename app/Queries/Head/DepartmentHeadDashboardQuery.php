<?php

declare(strict_types=1);

namespace App\Queries\Head;

use App\Data\Head\DepartmentHeadDashboardData;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use App\Models\Lookup\Gender;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Database\Eloquent\Builder;

final readonly class DepartmentHeadDashboardQuery
{
    public function __construct(
        private Employee $departmentHead
    ) {}

    /**
     * @return DepartmentHeadDashboardData The current department's summary.
     */
    public function run(): DepartmentHeadDashboardData
    {
        return new DepartmentHeadDashboardData(
            activeStaffCount: $this->activeStaffCount(),
            maleStaffCount: $this->activeStaffCount(Gender::MALE),
            femaleStaffCount: $this->activeStaffCount(Gender::FEMALE),
            pendingRegularLeaveCount: $this->pendingRegularLeaveCount(),
            pendingShortLeaveCount: $this->pendingShortLeaveCount(),
            employeesOnLeaveTodayCount: $this->employeesOnLeaveTodayCount(),
        );
    }

    /**
     * @return Builder<Employee>
     */
    private function subordinates(): Builder
    {
        return $this->departmentHead
            ->subordinates()
            ->getQuery()
            ->where('is_active', true);
    }

    private function activeStaffCount(?int $genderId = null): int
    {
        return $this
            ->subordinates()
            ->when(
                $genderId,
                fn ($query) => $query->where('gender_id', $genderId))
            ->count();
    }

    /**
     * @return Builder<Employee>
     */
    private function subordinateIds(): Builder
    {
        return $this->subordinates()
            ->select('employees.id');
    }

    private function pendingRegularLeaveCount(): int
    {
        return LeaveRequest::query()
            ->whereIn('employee_id', $this->subordinateIds())
            ->whereHas(
                'workflowActions',
                fn ($query) => $query->where('status', WorkflowActionEnum::PENDING->value))
            ->count();
    }

    private function pendingShortLeaveCount(): int
    {
        return ShortLeaveRequest::query()
            ->whereIn('employee_id', $this->subordinateIds())
            ->whereHas(
                'workflowActions',
                fn ($query) => $query->where('status', WorkflowActionEnum::PENDING->value))
            ->count();
    }

    private function employeesOnLeaveTodayCount(): int
    {
        return LeaveRequest::query()
            ->whereIn('employee_id', $this->subordinateIds())
            ->where('status', WorkflowActionEnum::APPROVED->value)
            ->whereDate('start_date', '<=', today())
            ->whereDate('end_date', '>=', today())
            ->distinct()
            ->count('employee_id');
    }
}
