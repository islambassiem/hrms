<?php

declare(strict_types=1);

namespace App\Http\Controllers\Head;

use App\Data\Head\DepartmentHeadEmployeeFiltersData;
use App\Http\Requests\Head\IndexDepartmentHeadEmployeesRequest;
use App\Http\Resources\Head\DepartmentHeadDirectoryEmployeeResource;
use App\Http\Resources\Head\DepartmentHeadEmployeeDetailsResource;
use App\Http\Resources\Head\DepartmentHeadEmployeeQualificationResource;
use App\Http\Resources\Lookup\IdNameResource;
use App\Lookups\GenderLookup;
use App\Models\Employee\Employee;
use App\Queries\Head\DepartmentHeadEmployeeDetailsQuery;
use App\Queries\Head\DepartmentHeadEmployeeDirectoryQuery;
use App\Queries\Qualification\EmployeeQualificationsQuery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class EmployeeController
{
    public function index(
        IndexDepartmentHeadEmployeesRequest $request,
        DepartmentHeadEmployeeDirectoryQuery $query,
        GenderLookup $genders
    ): Response {
        /** @var Employee $head */
        $head = $request->attributes->get('head');

        $validated = $request->validated();
        $filters = DepartmentHeadEmployeeFiltersData::from([
            'search' => $validated['search'] ?? null,
            'genderId' => $validated['gender_id'] ?? null,
        ]);

        return Inertia::render('head/employees/index', [
            'filters' => [
                'search' => $filters->search,
                'genderId' => $filters->genderId,
            ],
            'genders' => IdNameResource::collection(
                $genders->get(),
            )->resolve($request),
            'employees' => DepartmentHeadDirectoryEmployeeResource::collection(
                $query->run($head, $filters)
                    ->paginate(15)
                    ->withQueryString(),
            ),
        ]);
    }

    public function show(
        Request $request,
        int $employeeId,
        DepartmentHeadEmployeeDetailsQuery $employeeQuery,
        EmployeeQualificationsQuery $qualificationQuery
    ): Response {
        /** @var Employee $head */
        $head = $request->attributes->get('head');
        $employee = $employeeQuery
            ->run($head, $employeeId)
            ->firstOrFail();
        $qualifications = $qualificationQuery
            ->run($employee)
            ->get();

        return Inertia::render('head/employees/show', [
            'employee' => DepartmentHeadEmployeeDetailsResource::make($employee)
                ->resolve($request),
            'qualifications' => DepartmentHeadEmployeeQualificationResource::collection(
                $qualifications,
            )->resolve($request),
        ]);
    }
}
