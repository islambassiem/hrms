<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Workflow\WorkflowAction;
use App\Models\Workflow\WorkflowStep;
use Illuminate\Database\Seeder;

class WorkflowActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $stepIds = WorkflowStep::query()->pluck('id');
        $employeeIds = Employee::query()->pluck('id');

        WorkflowAction::factory(60)->create([
            'workflow_step_id' => fn () => $stepIds->random(),
            'actor_id' => fn () => $employeeIds->random(),
        ]);
    }
}
