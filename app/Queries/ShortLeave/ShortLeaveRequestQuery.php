<?php

declare(strict_types=1);

namespace App\Queries\ShortLeave;

use App\Data\ShortLeave\ShortLeaveRequestFiltersData;
use App\Models\ShortLeave\ShortLeaveRequest;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Builder;

final readonly class ShortLeaveRequestQuery
{
    public function __construct(
        private ShortLeaveRequestFiltersData $filters,
    ) {}

    /**
     * @return Builder<ShortLeaveRequest>
     */
    public function run(): Builder
    {
        return ShortLeaveRequest::query()
            ->with('shortLeaveType')
            ->where('employee_id', $this->filters->employeeId)
            ->when(
                $this->filters->shortLeaveTypeId,
                fn ($query, int $shortLeaveTypeId): Builder => $query->where(
                    'short_leave_type_id',
                    $shortLeaveTypeId,
                ),
            )
            ->when(
                $this->filters->fromDate,
                fn ($query, CarbonImmutable $fromDate): Builder => $query->whereDate(
                    'short_leave_date',
                    '>=',
                    $fromDate,
                ),
            )
            ->when(
                $this->filters->toDate,
                fn ($query, CarbonImmutable $toDate): Builder => $query->whereDate(
                    'short_leave_date',
                    '<=',
                    $toDate,
                ),
            )
            ->latest();
    }
}
