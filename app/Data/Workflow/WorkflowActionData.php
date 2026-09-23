<?php

declare(strict_types=1);

namespace App\Data\Workflow;

use App\Enums\WorkflowActionEnum;
use Spatie\LaravelData\Data;

final class WorkflowActionData extends Data
{
    public function __construct(
        public ?int $workflow_step_id,
        public ?string $actionable_type,
        public ?int $actionable_id,
        public ?int $actor_id,
        public ?int $role_id,
        public ?WorkflowActionEnum $action,
        public ?string $comment = null,
    ) {}
}
