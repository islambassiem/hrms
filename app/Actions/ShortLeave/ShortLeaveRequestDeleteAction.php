<?php

declare(strict_types=1);

namespace App\Actions\ShortLeave;

use App\Enums\WorkflowActionEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Support\Facades\DB;

final class ShortLeaveRequestDeleteAction
{
    /**
     * @throws CannotDeleteRecord
     */
    public function handle(ShortLeaveRequest $shortLeaveRequest): void
    {
        if ($shortLeaveRequest->status === WorkflowActionEnum::APPROVED->value) {
            throw new CannotDeleteRecord(
                __('An approved Short Leave request cannot be deleted.')
            );
        }

        DB::transaction(function () use ($shortLeaveRequest): void {
            $shortLeaveRequest->delete();
        });
    }
}
