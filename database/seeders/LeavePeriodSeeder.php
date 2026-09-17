<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Leave\LeavePeriod;
use Illuminate\Database\Seeder;

class LeavePeriodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        LeavePeriod::factory(3)->create();
    }
}
