<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Leave\LeaveCarryover;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeavePeriod;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Seeder;

class LeaveCarryoverSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $typeIds = LeaveType::query()->pluck('id');
        $periodIds = LeavePeriod::query()->pluck('id');
        $entitlementIds = LeaveEntitlement::query()->pluck('id');

        LeaveCarryover::factory(10)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'leave_type_id' => fn () => $typeIds->random(),
            'from_period_id' => fn () => $periodIds->random(),
            'to_period_id' => fn () => $periodIds->random(),
            'source_entitlement_id' => fn () => $entitlementIds->random(),
            'target_entitlement_id' => fn () => $entitlementIds->random(),
            'requested_by' => fn () => $employeeIds->random(),
            'approved_by' => fn () => $employeeIds->random(),
        ]);
    }
}
