<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveEntitlementValidationRules;
use App\Data\Leave\LeaveEntitlementData;
use App\Models\Leave\LeaveEntitlement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates LeaveEntitlement records after validation. */
final class LeaveEntitlementUpdateAction
{
    use LeaveEntitlementValidationRules;

    /** @param LeaveEntitlement $model The model to update. @param LeaveEntitlementData $data The replacement data. @return LeaveEntitlement The refreshed model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeaveEntitlement $model, LeaveEntitlementData $data): LeaveEntitlement
    {
        Validator::make($data->toArray(), $this->updateRules($model))->validate();

        return DB::transaction(function () use ($model, $data): LeaveEntitlement {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            $model->update($payload);

            return $model->refresh();
        });
    }
}
