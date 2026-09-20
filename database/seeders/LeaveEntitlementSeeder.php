<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Leave\LeaveEntitlement;
use App\Models\Leave\LeavePeriod;
use App\Models\Leave\LeavePolicy;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Seeder;
use RuntimeException;

class LeaveEntitlementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $typeIds = LeaveType::query()->pluck('id');
        $policyIds = LeavePolicy::query()->pluck('id');
        $periodIds = LeavePeriod::query()->pluck('id');
        $count = 50;

        $combinations = collect($employeeIds)
            ->flatMap(
                fn ($employeeId) => collect($policyIds)->flatMap(
                    fn ($policyId) => collect($periodIds)->map(
                        fn ($periodId): array => [
                            'employee_id' => $employeeId,
                            'leave_policy_id' => $policyId,
                            'leave_period_id' => $periodId,
                        ])
                )
            )
            ->shuffle();

        if ($combinations->count() < $count) {
            throw new RuntimeException(
                "Cannot create {$count} unique leave entitlements. ".
                "Only {$combinations->count()} combinations are possible."
            );
        }

        $combinations
            ->take($count)
            ->each(fn ($combination) => LeaveEntitlement::factory()->create([
                ...$combination,
                'leave_type_id' => $typeIds->random(),
            ])
            );

    }
}
