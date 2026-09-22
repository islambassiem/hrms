<?php

declare(strict_types=1);

namespace App\Actions\ShortLeave;

use App\Concerns\ShortLeave\ShortLeaveRequestValidationRules;
use App\Data\ShortLeave\ShortLeaveRequestData;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates short leave requests. */
final class ShortLeaveRequestUpdateAction
{
    use ShortLeaveRequestValidationRules;

    /** @param ShortLeaveRequest $shortLeaveRequest The request to update. @param ShortLeaveRequestData $data The replacement data. @return ShortLeaveRequest The refreshed request. @throws \Illuminate\Validation\ValidationException */
    public function handle(ShortLeaveRequest $shortLeaveRequest, ShortLeaveRequestData $data): ShortLeaveRequest
    {
        Validator::make($data->toArray(), $this->updateRules($shortLeaveRequest))->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($shortLeaveRequest, $data, $currentUserId): ShortLeaveRequest {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $shortLeaveRequest->updated_by,
            ];

            $shortLeaveRequest->update($payload);

            return $shortLeaveRequest->refresh();
        });
    }
}
