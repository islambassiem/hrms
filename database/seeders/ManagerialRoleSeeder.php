<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Lookup\ManagerialRole;
use Illuminate\Database\Seeder;

class ManagerialRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ManagerialRole::factory(10)->create();
    }
}
