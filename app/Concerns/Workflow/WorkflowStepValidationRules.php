<?php

declare(strict_types=1);

namespace App\Concerns\Workflow;

use App\Models\Workflow\WorkflowStep;
use Illuminate\Validation\Rule;

trait WorkflowStepValidationRules
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
    public function updateRules(WorkflowStep $step): array
    {
        return self::baseRules();
    }

    /**
     * @return array<string, mixed>
     */
    public function baseRules(): array
    {
        return [
            'workflow_id' => [
                'required',
                'integer',
                Rule::exists('lookup_workflows', 'id'),
            ],
            'name_en' => ['required', 'string', 'max:255'],
            'name_ar' => ['required', 'string', 'max:255'],
            'code' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'step_order' => ['required', 'integer', 'min:1'],
            'role_id' => [
                'required',
                'integer',
                Rule::exists('spatie_roles', 'id'),
            ],
        ];
    }
}
