<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeDependent;
use App\Models\Lookup\FamilyRelationship;
use App\Models\Lookup\Gender;
use Illuminate\Database\Seeder;

class EmployeeDependentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $genderIds = Gender::query()->pluck('id');
        $relationshipIds = FamilyRelationship::query()->pluck('id');

        EmployeeDependent::factory(100)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'gender_id' => fn () => $genderIds->random(),
            'relationship_id' => fn () => $relationshipIds->random(),
        ]);
    }
}
