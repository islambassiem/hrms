<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeIdentity;
use App\Models\Lookup\IdentityType;
use Illuminate\Database\Seeder;

class EmployeeIdentitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $typeIds = IdentityType::query()->pluck('id');

        EmployeeIdentity::factory(10)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'identity_type_id' => fn () => $typeIds->random(),
        ]);
    }
}
