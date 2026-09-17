<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Leave\LeavePolicy;
use App\Models\Lookup\LeaveType;
use Illuminate\Database\Seeder;

class LeavePolicySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $typeIds = LeaveType::query()->pluck('id');

        LeavePolicy::factory(5)->create([
            'leave_type_id' => fn () => $typeIds->random(),
        ]);
    }
}
