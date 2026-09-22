<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveEntitlementValidationRules;
use App\Data\Leave\LeaveEntitlementData;
use App\Models\Leave\LeaveEntitlement;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates LeaveEntitlement records after validation. */
final class LeaveEntitlementCreateAction
{
    use LeaveEntitlementValidationRules;

    /** @param LeaveEntitlementData $data The data to persist. @return LeaveEntitlement The created model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeaveEntitlementData $data): LeaveEntitlement
    {
        Validator::make($data->toArray(), $this->createRules())->validate();

        return DB::transaction(function () use ($data): LeaveEntitlement {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            /** @var LeaveEntitlement $leaveEntitlement */
            $leaveEntitlement = LeaveEntitlement::query()->create($payload);

            return $leaveEntitlement;
        });
    }
}
