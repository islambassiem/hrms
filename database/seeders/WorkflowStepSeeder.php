<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Lookup\Workflow;
use App\Models\Workflow\WorkflowStep;
use Illuminate\Database\Seeder;

class WorkflowStepSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $workflowIds = Workflow::query()->pluck('id');

        WorkflowStep::factory(50)->create([
            'workflow_id' => fn () => $workflowIds->random(),
        ]);
    }
}
