<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Enums\WorkflowActionEnum;
use App\Models\Leave\LeaveRequest;

class LeaveRequestDeleteAction
{
    public function handle(LeaveRequest $leave): void
    {
        if ($leave->status === WorkflowActionEnum::PENDING->value) {
            $leave->delete();
        }
    }
}
