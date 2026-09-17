<?php

declare(strict_types=1);

namespace Database\Factories\Workflow;

use App\Enums\WorkflowActionEnum;
use App\Models\Employees\Employee;
use App\Models\Workflow\WorkflowAction;
use App\Models\Workflow\WorkflowStep;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<WorkflowAction>
 */
class WorkflowActionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $role = Role::query()
            ->create([
                'name' => fake()->lexify('??????????'),
                'guard_name' => 'web',
            ]);

        return [
            'workflow_step_id' => WorkflowStep::factory(),
            'actionable_type' => fake()->randomElement(['\\App\\Models\\Leaves\\Leave', '\\App\\Models\\Permission\\Permission']),
            'actionable_id' => fake()->numberBetween(),
            'actor_id' => Employee::factory(),
            'role_id' => $role->id,
            'action' => fake()->randomElement(WorkflowActionEnum::cases()),
            'comment' => fake()->sentence(),
        ];
    }
}
