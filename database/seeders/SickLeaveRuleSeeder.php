<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Leave\SickLeaveRule;
use Illuminate\Database\Seeder;

class SickLeaveRuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SickLeaveRule::factory(3)->create();
    }
}
