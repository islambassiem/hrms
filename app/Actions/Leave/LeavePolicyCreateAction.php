<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeavePolicyValidationRules;
use App\Data\Leave\LeavePolicyData;
use App\Models\Leave\LeavePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates LeavePolicy records after validation. */
final class LeavePolicyCreateAction
{
    use LeavePolicyValidationRules;

    /** @param LeavePolicyData $data The data to persist. @return LeavePolicy The created model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeavePolicyData $data): LeavePolicy
    {
        Validator::make($data->toArray(), $this->createRules())->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): LeavePolicy {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var LeavePolicy $leavePolicy */
            $leavePolicy = LeavePolicy::query()->create($payload);

            return $leavePolicy;
        });
    }
}
