<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Models\Employee\Employee;
use App\Models\Lookup\ShortLeaveType;
use App\Models\ShortLeave\ShortLeaveRequest;
use Carbon\CarbonImmutable;
use Carbon\CarbonInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin ShortLeaveRequest
 */
final class DepartmentHeadShortLeaveRequestResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var CarbonImmutable $date */
        $date = $this->short_leave_date;

        /** @var CarbonImmutable $from */
        $from = $this->short_leave_from;

        /** @var CarbonImmutable $to */
        $to = $this->short_leave_to;

        /** @var CarbonInterface $submittedAt */
        $submittedAt = $this->created_at;

        $employee = $this->relationLoaded('employee')
            ? $this->getRelation('employee')
            : null;
        $shortLeaveType = $this->relationLoaded('shortLeaveType')
            ? $this->getRelation('shortLeaveType')
            : null;

        return [
            'id' => $this->id,
            'employee' => $employee instanceof Employee ? [
                'id' => $employee->id,
                'name' => $employee->name,
                'employeeCode' => $employee->employee_code,
            ] : null,
            'shortLeaveType' => $shortLeaveType instanceof ShortLeaveType ? [
                'id' => $shortLeaveType->id,
                'name' => $shortLeaveType->name,
            ] : null,
            'date' => $date->toDateString(),
            'from' => $from->format('H:i'),
            'to' => $to->format('H:i'),
            'status' => $this->status,
            'submittedDate' => $submittedAt->toDateString(),
        ];
    }
}
