<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveCarryoverValidationRules;
use App\Data\Leave\LeaveCarryoverData;
use App\Models\Leave\LeaveCarryover;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates LeaveCarryover records after validation. */
final class LeaveCarryoverUpdateAction
{
    use LeaveCarryoverValidationRules;

    /** @param LeaveCarryover $model The model to update. @param LeaveCarryoverData $data The replacement data. @return LeaveCarryover The refreshed model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeaveCarryover $model, LeaveCarryoverData $data): LeaveCarryover
    {
        Validator::make($data->toArray(), $this->updateRules($model))->validate();

        return DB::transaction(function () use ($model, $data): LeaveCarryover {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            $model->update($payload);

            return $model->refresh();
        });
    }
}
