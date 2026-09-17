<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Leave\LeaveEncashment;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Seeder;

class LeaveEncashmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $emplpyeeIds = Employee::query()->pluck('id');
        $typeIds = LeaveType::query()->pluck('id');
        $entitlementIds = LeaveEntitlement::query()->pluck('id');

        LeaveEncashment::factory(5)->create([
            'employee_id' => fn () => $emplpyeeIds->random(),
            'leave_type_id' => fn () => $typeIds->random(),
            'leave_entitlement_id' => fn () => $entitlementIds->random(),
            'approved_by' => fn () => $emplpyeeIds->random(),
        ]);
    }
}
