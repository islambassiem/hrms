<?php

declare(strict_types=1);

namespace App\Queries\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Employee\Employee;
use App\Models\Leave\LeaveRequest;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final readonly class EmployeeDashboardLeaveRequestQuery
{
    public function __construct(
        private Employee $employee,
        private CarbonImmutable $asOfDate,
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
            ->oldest('start_date')
            ->orderBy('id');
    }
}
