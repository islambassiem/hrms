<?php

namespace App\Actions\Workflow;

use App\Concerns\Workflow\WorkflowStepValidationRules;
use App\Data\Workflow\WorkflowStepData;
use App\Models\Workflow\WorkflowStep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class WorkflowStepCreateAction
{
    use WorkflowStepValidationRules;

    public function handle(WorkflowStepData $data): WorkflowStep
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): WorkflowStep {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var WorkflowStep $step */
            $step = WorkflowStep::query()->create($payload);

            return $step;
        });
    }
}
