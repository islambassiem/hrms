<?php

declare(strict_types=1);

namespace App\Queries\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final class EmployeeDashboardLeaveRequestQuery
{
    public function __construct(
        private readonly Employee $employee,
        private readonly CarbonImmutable $asOfDate,
    ) {}

    /**
     * @return Builder<LeaveRequest>
     */
    public function pending(): Builder
    {
        return LeaveRequest::query()
            ->with('leaveType')
            ->where('employee_id', $this->employee->id)
            ->where('status', WorkflowActionEnum::PENDING->value)
            ->latest();
    }

    /**
     * @return Builder<LeaveRequest>
     */
    public function ongoingOrUpcomingApproved(): Builder
    {
        return LeaveRequest::query()
            ->with('leaveType')
            ->where('employee_id', $this->employee->id)
            ->where('status', WorkflowActionEnum::APPROVED->value)
            ->whereDate('end_date', '>=', $this->asOfDate)
            ->orderBy('start_date')
            ->orderBy('id');
    }
}
