<?php

namespace App\Actions\Workflow;

use App\Concerns\Workflow\WorkflowActionValidationRules;
use App\Data\Workflow\WorkflowActionData;
use App\Models\Workflow\WorkflowAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class WorkflowActionUpdateAction
{
    use WorkflowActionValidationRules;

    public function handle(WorkflowAction $workflowAction, WorkflowActionData $data): WorkflowAction
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($workflowAction),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($workflowAction, $data, $currentUserId): WorkflowAction {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $workflowAction->updated_by,
            ];

            $workflowAction->update($payload);

            return $workflowAction->refresh();
        });
    }
}
