<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveRequestValidationRules;
use App\Data\Leave\LeaveRequestData;
use App\Models\Leave\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates leave requests. */
final class LeaveRequestUpdateAction
{
    use LeaveRequestValidationRules;

    /** @param LeaveRequest $leaveRequest The request to update. @param LeaveRequestData $data The replacement data. @return LeaveRequest The refreshed request. @throws \Illuminate\Validation\ValidationException */
    public function handle(LeaveRequest $leaveRequest, LeaveRequestData $data): LeaveRequest
    {
        Validator::make($data->toArray(), $this->updateRules($leaveRequest))->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($leaveRequest, $data, $currentUserId): LeaveRequest {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $leaveRequest->updated_by,
            ];

            $leaveRequest->update($payload);

            return $leaveRequest->refresh();
        });
    }
}
