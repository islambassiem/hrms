<?php

declare(strict_types=1);

namespace App\Http\Controllers\Head;

use App\Data\Head\DepartmentHeadShortLeaveFiltersData;
use App\Enums\PermissionEnum;
use App\Enums\WorkflowActionEnum;
use App\Http\Requests\Head\IndexDepartmentHeadShortLeaveRequest;
use App\Http\Resources\Head\DepartmentHeadEmployeeOptionResource;
use App\Http\Resources\Head\DepartmentHeadShortLeaveRequestResource;
use App\Http\Resources\Head\DepartmentHeadShortLeaveTypeOptionResource;
use App\Models\Employee\Employee;
use App\Models\User;
use App\Queries\Head\DepartmentHeadLeaveRequestQuery;
use App\Queries\Head\DepartmentHeadShortLeaveRequestQuery;
use Inertia\Inertia;
use Inertia\Response;

final class ShortLeaveController
{
    public function index(IndexDepartmentHeadShortLeaveRequest $request): Response
    {
        $user = $request->user();

        abort_unless(
            $user instanceof User && $user->can(PermissionEnum::HEAD_PAGE->value),
            403,
        );

        $departmentHead = $user->employee()->first();

        abort_unless($departmentHead instanceof Employee, 403);

        $validated = $request->validated();
        $filters = DepartmentHeadShortLeaveFiltersData::from([
            'employeeId' => $validated['employee_id'] ?? null,
            'shortLeaveTypeId' => $validated['short_leave_type_id'] ?? null,
            'status' => $validated['status'] ?? null,
            'fromDate' => $validated['from_date'] ?? null,
            'toDate' => $validated['to_date'] ?? null,
        ]);
        $query = resolve(DepartmentHeadShortLeaveRequestQuery::class);
        $employeeQuery = resolve(DepartmentHeadLeaveRequestQuery::class);

        return Inertia::render('head/short-leaves/index', [
            'filters' => [
                'employeeId' => $filters->employeeId,
                'shortLeaveTypeId' => $filters->shortLeaveTypeId,
                'status' => $filters->status,
                'fromDate' => $filters->fromDate?->toDateString(),
                'toDate' => $filters->toDate?->toDateString(),
            ],
            'employees' => DepartmentHeadEmployeeOptionResource::collection(
                $employeeQuery->activeSubordinates($departmentHead)->get(),
            )->resolve($request),
            'shortLeaveTypes' => DepartmentHeadShortLeaveTypeOptionResource::collection(
                $query->shortLeaveTypes()->get(),
            )->resolve($request),
            'statuses' => array_map(
                static fn (WorkflowActionEnum $status): string => $status->value,
                WorkflowActionEnum::cases(),
            ),
            'shortLeaveRequests' => DepartmentHeadShortLeaveRequestResource::collection(
                $query->run($departmentHead, $filters)
                    ->paginate()
                    ->withQueryString(),
            ),
        ]);
    }
}
