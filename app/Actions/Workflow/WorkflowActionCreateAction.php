<?php

namespace App\Actions\Workflow;

use App\Concerns\Workflow\WorkflowActionValidationRules;
use App\Data\Workflow\WorkflowActionData;
use App\Models\Workflow\WorkflowAction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class WorkflowActionCreateAction
{
    use WorkflowActionValidationRules;

    public function handle(WorkflowActionData $data): WorkflowAction
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): WorkflowAction {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var WorkflowAction $workflowAction */
            $workflowAction = WorkflowAction::query()->create($payload);

            return $workflowAction;
        });
    }
}
