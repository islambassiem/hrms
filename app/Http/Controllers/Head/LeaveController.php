<?php

declare(strict_types=1);

namespace App\Http\Controllers\Head;

use App\Data\Head\DepartmentHeadLeaveFiltersData;
use App\Enums\PermissionEnum;
use App\Enums\WorkflowActionEnum;
use App\Http\Requests\Head\IndexDepartmentHeadLeaveRequest;
use App\Http\Resources\Head\DepartmentHeadEmployeeOptionResource;
use App\Http\Resources\Head\DepartmentHeadLeaveRequestResource;
use App\Http\Resources\Leave\LeaveTypeOptionResource;
use App\Models\Employee\Employee;
use App\Models\User;
use App\Queries\Head\DepartmentHeadLeaveRequestQuery;
use Inertia\Inertia;
use Inertia\Response;

final class LeaveController
{
    public function index(IndexDepartmentHeadLeaveRequest $request): Response
    {
        $user = $request->user();

        abort_unless(
            $user instanceof User && $user->can(PermissionEnum::HEAD_PAGE->value),
            403,
        );

        $departmentHead = $user->employee()->first();

        abort_unless($departmentHead instanceof Employee, 403);

        $validated = $request->validated();
        $filters = DepartmentHeadLeaveFiltersData::from([
            'employeeId' => $validated['employee_id'] ?? null,
            'leaveTypeId' => $validated['leave_type_id'] ?? null,
            'status' => $validated['status'] ?? null,
            'startDate' => $validated['start_date'] ?? null,
            'endDate' => $validated['end_date'] ?? null,
        ]);
        $query = resolve(DepartmentHeadLeaveRequestQuery::class);

        return Inertia::render('head/leaves/index', [
            'filters' => [
                'employeeId' => $filters->employeeId,
                'leaveTypeId' => $filters->leaveTypeId,
                'status' => $filters->status,
                'startDate' => $filters->startDate?->toDateString(),
                'endDate' => $filters->endDate?->toDateString(),
            ],
            'employees' => DepartmentHeadEmployeeOptionResource::collection(
                $query->activeSubordinates($departmentHead)->get(),
            )->resolve($request),
            'leaveTypes' => LeaveTypeOptionResource::collection(
                $query->leaveTypes()->get(),
            )->resolve($request),
            'statuses' => array_map(
                static fn (WorkflowActionEnum $status): string => $status->value,
                WorkflowActionEnum::cases(),
            ),
            'leaveRequests' => DepartmentHeadLeaveRequestResource::collection(
                $query->run($departmentHead, $filters)
                    ->paginate()
                    ->withQueryString(),
            ),
        ]);
    }
}
