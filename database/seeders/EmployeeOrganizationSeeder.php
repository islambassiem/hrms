<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeOrganization;
use App\Models\Organization\Organization;
use Illuminate\Database\Seeder;

class EmployeeOrganizationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employees = Employee::query()->pluck('id');

        foreach ($employees as $employee) {
            EmployeeOrganization::factory()->create([
                'employee_id' => $employee,
                'organization_id' => fn () => Organization::query()->pluck('id')->random(),
            ]);
        }
    }
}
