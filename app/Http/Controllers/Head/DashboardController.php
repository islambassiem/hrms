<?php

declare(strict_types=1);

namespace App\Http\Controllers\Head;

use App\Enums\PermissionEnum;
use App\Http\Resources\Head\DepartmentHeadDashboardResource;
use App\Models\Employee\Employee;
use App\Models\User;
use App\Queries\Head\DepartmentHeadDashboardQuery;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

final class DashboardController
{
    public function index(Request $request): Response
    {
        $user = $request->user();

        abort_unless(
            $user instanceof User && $user->can(PermissionEnum::HEAD_PAGE->value),
            403,
        );

        $departmentHead = $user->employee;

        abort_unless($departmentHead instanceof Employee, 403);

        $dashboard = resolve(DepartmentHeadDashboardQuery::class, [
            'departmentHead' => $departmentHead,
        ])->run();

        return Inertia::render('head/dashboard', [
            'headDashboard' => DepartmentHeadDashboardResource::make($dashboard)->resolve($request),
        ]);
    }
}
