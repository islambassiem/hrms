<?php

declare(strict_types=1);

namespace App\Services\Leave;

use App\Enums\LeaveTypeEnum;
use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\EmployeeLeavePolicy;
use App\Models\Leave\LeaveBalance;
use App\Models\Leave\LeaveRequest;
use Carbon\CarbonImmutable;

class LeaveService
{
    public function getAnnualLeaveBalance(Employee $employee, ?CarbonImmutable $endDate = null): int
    {
        return (int) ceil(
            $this->currentAnnualLeaveBalance($employee)
            + $this->futureBalance($employee, $endDate)
            - $this->pendingAnnualLeaveRequests($employee)
        );
    }

    public function getEmployeeCurrentAnnualLeavePolicy(Employee $employee): ?EmployeeLeavePolicy
    {
        return EmployeeLeavePolicy::query()
            ->with('policy')
            ->whereHas('policy', fn ($query) => $query->where('leave_type_id', LeaveTypeEnum::ANNUAL->value))
            ->where('employee_id', $employee->id)
            ->whereNull('end_date')
            ->first();
    }

    private function futureBalance(Employee $employee, ?CarbonImmutable $endDate = null): int
    {
        $startDate = CarbonImmutable::today();
        $endDate ??= $startDate;
        $policy = $this->getEmployeeCurrentAnnualLeavePolicy($employee);

        $policyDays = (int) $policy?->policy?->days_per_year;

        return (int) ceil($policyDays * ($startDate->diffInDays($endDate) + 1) / 12 / 30);

    }

    private function pendingAnnualLeaveRequests(Employee $employee): int
    {
        return (int) LeaveRequest::query()
            ->where('employee_id', $employee->id)
            ->where('leave_type_id', LeaveTypeEnum::ANNUAL->value)
            ->where('status', WorkflowActionEnum::PENDING->value)
            ->sum('no_of_days');
    }

    private function currentAnnualLeaveBalance(Employee $employee): int
    {
        return (int) LeaveBalance::query()
            ->where('employee_id', $employee->id)
            ->where('leave_type_id', LeaveTypeEnum::ANNUAL->value)
            ->first('available_days')
            ?->available_days;
    }
}
