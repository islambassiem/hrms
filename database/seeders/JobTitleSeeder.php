<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Lookup\JobTitle;
use Illuminate\Database\Seeder;

class JobTitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        JobTitle::factory(10)->create();
    }
}
