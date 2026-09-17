<?php

declare(strict_types=1);

namespace Database\Factories\Workflow;

use App\Models\Lookup\Workflow;
use App\Models\Workflow\WorkflowStep;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Permission\Models\Role;

/**
 * @extends Factory<WorkflowStep>
 */
class WorkflowStepFactory extends Factory
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
            'workflow_id' => Workflow::factory(),
            'name_en' => fake()->word(),
            'name_ar' => fake('ar_SA')->word(),
            'code' => fake()->unique()->numberBetween(1, 10000000000000),
            'description' => fake()->sentence(),
            'step_order' => fake()->numberBetween(1, 50),
            'role_id' => $role->id,
        ];
    }
}
