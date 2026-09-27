<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeAddress;
use Illuminate\Database\Seeder;

class EmployeeAddressSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::query()
            ->each(function (Employee $employee): void {
                EmployeeAddress::query()->updateOrCreate(
                    ['employee_id' => $employee->id],
                    EmployeeAddress::factory()->make([
                        'employee_id' => $employee->id,
                    ])->toArray(),
                );
            });
    }
}
