<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeavePolicyValidationRules;
use App\Data\Leave\LeavePolicyData;
use App\Models\Leave\LeavePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates LeavePolicy records after validation. */
final class LeavePolicyUpdateAction
{
    use LeavePolicyValidationRules;

    /** @param LeavePolicy $model The model to update. @param LeavePolicyData $data The replacement data. @return LeavePolicy The refreshed model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeavePolicy $model, LeavePolicyData $data): LeavePolicy
    {
        Validator::make($data->toArray(), $this->updateRules($model))->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($model, $data, $currentUserId): LeavePolicy {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $model->updated_by,
            ];

            $model->update($payload);

            return $model->refresh();
        });
    }
}
