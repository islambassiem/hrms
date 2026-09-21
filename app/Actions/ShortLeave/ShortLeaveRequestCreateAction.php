<?php

declare(strict_types=1);

namespace App\Actions\ShortLeave;

use App\Concerns\ShortLeave\ShortLeaveRequestValidationRules;
use App\Data\ShortLeave\ShortLeaveRequestData;
use App\Models\ShortLeave\ShortLeaveRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates short leave requests. */
final class ShortLeaveRequestCreateAction
{
    use ShortLeaveRequestValidationRules;

    /** @param ShortLeaveRequestData $data The data to persist. @return ShortLeaveRequest The created request. @throws \Illuminate\Validation\ValidationException */
    public function handle(ShortLeaveRequestData $data): ShortLeaveRequest
    {
        Validator::make($data->toArray(), $this->createRules())->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): ShortLeaveRequest {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var ShortLeaveRequest $shortLeaveRequest */
            $shortLeaveRequest = ShortLeaveRequest::query()->create($payload);

            return $shortLeaveRequest;
        });
    }
}
