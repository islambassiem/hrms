<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Lookup\Workflow;
use Illuminate\Database\Seeder;

class WorkflowSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Workflow::factory(5)->create();
    }
}
