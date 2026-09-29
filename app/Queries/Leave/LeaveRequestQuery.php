<?php

namespace App\Queries\Leave;

use App\Data\Leave\LeaveRequestFiltersData;
use App\Data\Leave\LeaveRequestSortData;
use App\Models\Leave\LeaveRequest;
use Carbon\CarbonImmutable;
use Illuminate\Contracts\Database\Eloquent\Builder;

final class LeaveRequestQuery
{
    public function __construct(
        public LeaveRequestFiltersData $filters,
        public ?LeaveRequestSortData $sort = null
    ) {}


    public function run(): Builder
    {
        $query = LeaveRequest::query()
            ->when(
                $this->filters->employeeIds,
                fn (Builder $query, array $employeeIds) => $query->whereIn('employee_id', $employeeIds)
            )
            ->when(
                $this->filters->leaveTypeIds,
                fn (Builder $query, array $leaveTypeIds) => $query->whereIn('leave_type_id', $leaveTypeIds)
            )
            ->when(
                $this->filters->departmentIds,
                fn (Builder $query, array $departmentIds) => $query->whereHas(
                    'employee',
                    fn (Builder $query) => $query->whereIn('department_id', $departmentIds)
                )
            )
            ->when(
                $this->filters->genderIds,
                fn (Builder $query, array $genderIds) => $query->whereHas(
                    'employee',
                    fn (Builder $query) => $query->whereIn('gender_id', $genderIds)
                )
            )
            ->when(
                $this->filters->statuses,
                fn (Builder $query, array $status) => $query->whereIn('status', $status)
            )
            ->when(
                $this->filters->startDate,
                fn (Builder $query, CarbonImmutable $startDate) => $query->whereDate('start_date', '>=', $startDate)
            )
            ->when(
                $this->filters->endDate,
                fn (Builder $query, CarbonImmutable $endDate) => $query->whereDate('end_date', '<=', $endDate)
            )->latest();

        if($this->sort){
            $query->orderBy($this->sort->field, $this->sort->order);
        }

        return $query;
    }
}
