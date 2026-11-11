<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\Employee;
use App\Models\Request\FamilyVisit;
use Illuminate\Database\Seeder;

class FamilyVisitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');

        FamilyVisit::factory(50)->create([
            'employee_id' => fn () => $employeeIds->random(),
        ]);
    }
}
