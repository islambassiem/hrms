<?php

declare(strict_types=1);

namespace App\Policies;

use App\Enums\WorkflowActionEnum;
use App\Models\ShortLeave\ShortLeaveRequest;
use App\Models\User;

final class ShortLeaveRequestPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->employee()->exists();
    }

    public function view(User $user, ShortLeaveRequest $shortLeaveRequest): bool
    {
        return $user->employee?->id === $shortLeaveRequest->employee_id;
    }

    public function create(User $user): bool
    {
        return $user->employee()->exists();
    }

    public function update(User $user, ShortLeaveRequest $shortLeaveRequest): bool
    {
        return $this->view($user, $shortLeaveRequest)
            && $shortLeaveRequest->status === WorkflowActionEnum::PENDING->value;
    }

    public function delete(User $user, ShortLeaveRequest $shortLeaveRequest): bool
    {
        return $this->view($user, $shortLeaveRequest)
            && $shortLeaveRequest->status !== WorkflowActionEnum::APPROVED->value;
    }
}
