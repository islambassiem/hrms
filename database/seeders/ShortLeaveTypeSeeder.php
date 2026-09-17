<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Lookup\ShortLeaveType;
use Illuminate\Database\Seeder;

class ShortLeaveTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ShortLeaveType::factory(3)->create();
    }
}
