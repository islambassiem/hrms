<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Data\Head\DepartmentHeadDashboardData;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use LogicException;

final class DepartmentHeadDashboardResource extends JsonResource
{
    /**
     * @return array{
     *     activeStaffCount: int,
     *     maleStaffCount: int,
     *     femaleStaffCount: int,
     *     pendingRegularLeaveCount: int,
     *     pendingShortLeaveCount: int,
     *     employeesOnLeaveTodayCount: int
     * }
     */
    public function toArray(Request $request): array
    {
        $dashboard = $this->dashboard();

        return [
            'activeStaffCount' => $dashboard->activeStaffCount,
            'maleStaffCount' => $dashboard->maleStaffCount,
            'femaleStaffCount' => $dashboard->femaleStaffCount,
            'pendingRegularLeaveCount' => $dashboard->pendingRegularLeaveCount,
            'pendingShortLeaveCount' => $dashboard->pendingShortLeaveCount,
            'employeesOnLeaveTodayCount' => $dashboard->employeesOnLeaveTodayCount,
        ];
    }

    private function dashboard(): DepartmentHeadDashboardData
    {
        if (! $this->resource instanceof DepartmentHeadDashboardData) {
            throw new LogicException('The Department Head dashboard resource requires dashboard data.');
        }

        return $this->resource;
    }
}
