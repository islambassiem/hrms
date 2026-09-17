<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeaveRequest;
use App\Models\Leave\LeaveTransaction;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Seeder;

class LeaveTransactionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $typeIds = LeaveType::query()->pluck('id');
        $requestIds = LeaveRequest::query()->pluck('id');
        $entitlementIds = LeaveEntitlement::query()->pluck('id');

        LeaveTransaction::factory(100)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'leave_type_id' => fn () => $typeIds->random(),
            'leave_entitlement_id' => fn () => $entitlementIds->random(),
            'leave_request_id' => fn () => $requestIds->random(),
        ]);
    }
}
