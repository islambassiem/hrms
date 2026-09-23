<?php

namespace App\Actions\Workflow;

use App\Concerns\Workflow\WorkflowStepValidationRules;
use App\Data\Workflow\WorkflowStepData;
use App\Models\Workflow\WorkflowStep;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class WorkflowStepUpdateAction
{
    use WorkflowStepValidationRules;

    public function handle(WorkflowStep $step, WorkflowStepData $data): WorkflowStep
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($step),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($step, $data, $currentUserId): WorkflowStep {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $step->updated_by,
            ];

            $step->update($payload);

            return $step->refresh();
        });
    }
}
