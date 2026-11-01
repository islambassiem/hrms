<?php

declare(strict_types=1);

namespace App\Actions\ShortLeave;

use App\Concerns\ShortLeave\ShortLeaveRequestValidationRules;
use App\Data\ShortLeave\ShortLeaveRequestData;
use App\Enums\WorkflowActionEnum;
use App\Exceptions\CannotUpdateRecord;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/** Updates short leave requests. */
final class ShortLeaveRequestUpdateAction
{
    use ShortLeaveRequestValidationRules;

    /**
     * Update employee-editable Short Leave fields while preserving workflow state.
     *
     * @throws CannotUpdateRecord
     * @throws ValidationException
     */
    public function handle(ShortLeaveRequest $shortLeaveRequest, ShortLeaveRequestData $data): ShortLeaveRequest
    {
        if ($shortLeaveRequest->status !== WorkflowActionEnum::PENDING->value) {
            throw new CannotUpdateRecord(
                __('A Short Leave request can only be updated while it is pending.')
            );
        }

        Validator::make($data->toArray(), $this->updateRules($shortLeaveRequest))->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($shortLeaveRequest, $data, $currentUserId): ShortLeaveRequest {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'employee_id' => $shortLeaveRequest->employee_id,
                'status' => $shortLeaveRequest->status,
                'updated_by' => $currentUserId ?? $shortLeaveRequest->updated_by,
            ];

            $shortLeaveRequest->update($payload);

            return $shortLeaveRequest->refresh();
        });
    }
}
