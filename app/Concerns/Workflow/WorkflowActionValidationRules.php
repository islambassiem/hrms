<?php

declare(strict_types=1);

namespace App\Concerns\Workflow;

use App\Enums\WorkflowActionEnum;
use App\Models\Workflow\WorkflowAction;
use Illuminate\Validation\Rule;

trait WorkflowActionValidationRules
{
    /**
     * @phpstan-type ValidationRule string|\Illuminate\Validation\Rules\Exists|\Illuminate\Validation\Rules\Unique|\Illuminate\Validation\Rule
     */

    /**
     * @return array<string, mixed>
     */
    public function createRules(): array
    {
        return self::baseRules();
    }

    /**
     * @return array<string, mixed>
     */
    public function updateRules(WorkflowAction $workflowAction): array
    {
        return self::baseRules();
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'workflow_step_id' => [
                'required',
                'integer',
                Rule::exists('workflow_steps', 'id'),
            ],
            'actionable_type' => ['required', 'string', 'max:255'],
            'actionable_id' => ['required', 'integer', 'min:1'],
            'actor_id' => [
                'required',
                'integer',
                Rule::exists('employees', 'id'),
            ],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('spatie_roles', 'id'),
            ],
            'action' => ['required', Rule::enum(WorkflowActionEnum::class)],
            'comment' => ['nullable', 'string'],
        ];
    }
}
