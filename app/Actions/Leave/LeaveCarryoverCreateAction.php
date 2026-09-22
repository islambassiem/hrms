<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveCarryoverValidationRules;
use App\Data\Leave\LeaveCarryoverData;
use App\Models\Leave\LeaveCarryover;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates LeaveCarryover records after validation. */
final class LeaveCarryoverCreateAction
{
    use LeaveCarryoverValidationRules;

    /** @param LeaveCarryoverData $data The data to persist. @return LeaveCarryover The created model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeaveCarryoverData $data): LeaveCarryover
    {
        Validator::make($data->toArray(), $this->createRules())->validate();

        return DB::transaction(function () use ($data): LeaveCarryover {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            /** @var LeaveCarryover $leaveCarryover */
            $leaveCarryover = LeaveCarryover::query()->create($payload);

            return $leaveCarryover;
        });
    }
}
