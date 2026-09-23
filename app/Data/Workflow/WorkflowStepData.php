<?php

declare(strict_types=1);

namespace App\Data\Workflow;

use Spatie\LaravelData\Data;

final class WorkflowStepData extends Data
{
    public function __construct(
        public ?int $workflow_id,
        public ?string $name_en,
        public ?string $name_ar,
        public ?int $step_order,
        public ?int $role_id,
        public ?string $code = null,
        public ?string $description = null,
    ) {}
}
