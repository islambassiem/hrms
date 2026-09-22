<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveRequestValidationRules;
use App\Data\Leave\LeaveRequestData;
use App\Models\Leave\LeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates leave requests. */
final class LeaveRequestCreateAction
{
    use LeaveRequestValidationRules;

    /** @param LeaveRequestData $data The data to persist. @return LeaveRequest The created request. @throws \Illuminate\Validation\ValidationException */
    public function handle(LeaveRequestData $data): LeaveRequest
    {
        Validator::make($data->toArray(), $this->createRules())->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): LeaveRequest {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var LeaveRequest $leaveRequest */
            $leaveRequest = LeaveRequest::query()->create($payload);

            return $leaveRequest;
        });
    }
}
