<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employee\EmployeeContract;
use Illuminate\Database\Seeder;

class EmployeeContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EmployeeContract::factory(50)->create();
    }
}
