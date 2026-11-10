<?php

declare(strict_types=1);

namespace App\Http\Controllers\Head;

use App\Data\Head\DepartmentHeadEmployeeFiltersData;
use App\Enums\PermissionEnum;
use App\Http\Requests\Head\IndexDepartmentHeadEmployeesRequest;
use App\Http\Resources\Head\DepartmentHeadDirectoryEmployeeResource;
use App\Http\Resources\Head\DepartmentHeadDirectoryGenderResource;
use App\Http\Resources\Head\DepartmentHeadEmployeeDetailsResource;
use App\Http\Resources\Head\DepartmentHeadEmployeeQualificationResource;
use App\Models\Employee\Employee;
use App\Models\User;
use App\Queries\Head\DepartmentHeadEmployeeDetailsQuery;
use App\Queries\Head\DepartmentHeadEmployeeDirectoryQuery;
use App\Queries\Qualification\EmployeeQualificationsQuery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class EmployeeController
{
    public function index(IndexDepartmentHeadEmployeesRequest $request): Response
    {
        $departmentHead = $this->authenticatedDepartmentHead($request);

        $validated = $request->validated();
        $filters = DepartmentHeadEmployeeFiltersData::from([
            'search' => $validated['search'] ?? null,
            'genderId' => $validated['gender_id'] ?? null,
        ]);
        $query = resolve(DepartmentHeadEmployeeDirectoryQuery::class);

        return Inertia::render('head/employees/index', [
            'filters' => [
                'search' => $filters->search,
                'genderId' => $filters->genderId,
            ],
            'genders' => DepartmentHeadDirectoryGenderResource::collection(
                $query->genders()->get(),
            )->resolve($request),
            'employees' => DepartmentHeadDirectoryEmployeeResource::collection(
                $query->run($departmentHead, $filters)
                    ->paginate(15)
                    ->withQueryString(),
            ),
        ]);
    }

    public function show(Request $request, int $employeeId): Response
    {
        $departmentHead = $this->authenticatedDepartmentHead($request);
        $employee = resolve(DepartmentHeadEmployeeDetailsQuery::class)
            ->run($departmentHead, $employeeId)
            ->firstOrFail();
        $qualifications = resolve(EmployeeQualificationsQuery::class)
            ->run($employee)
            ->orderByDesc('graduation_date')
            ->orderByDesc('id')
            ->get();

        return Inertia::render('head/employees/show', [
            'employee' => DepartmentHeadEmployeeDetailsResource::make($employee)
                ->resolve($request),
            'qualifications' => DepartmentHeadEmployeeQualificationResource::collection(
                $qualifications,
            )->resolve($request),
        ]);
    }

    private function authenticatedDepartmentHead(Request $request): Employee
    {
        $user = $request->user();

        abort_unless(
            $user instanceof User && $user->can(PermissionEnum::HEAD_PAGE->value),
            403,
        );

        $departmentHead = $user->employee()->first();

        abort_unless($departmentHead instanceof Employee, 403);

        return $departmentHead;
    }
}
