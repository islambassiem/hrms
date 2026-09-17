<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Leave\LeaveBalance;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Seeder;
use RuntimeException;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $typeIds = LeaveType::query()->pluck('id');

        $count = 50;

        $combinations = $employeeIds
            ->flatMap(fn ($employeeId) => $typeIds->map(fn ($typeId): array => [
                'employee_id' => $employeeId,
                'leave_type_id' => $typeId,
            ])
            )
            ->shuffle();

        if ($combinations->count() < $count) {
            throw new RuntimeException(
                "Cannot create {$count} leave balances. ".
                "Only {$combinations->count()} unique employee/leave-type combinations are possible."
            );
        }

        $combinations
            ->take($count)
            ->each(fn ($combination) => LeaveBalance::factory()->create($combination)
            );
    }
}
