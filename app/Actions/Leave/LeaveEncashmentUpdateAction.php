<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveEncashmentValidationRules;
use App\Data\Leave\LeaveEncashmentData;
use App\Models\Leave\LeaveEncashment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates LeaveEncashment records after validation. */
final class LeaveEncashmentUpdateAction
{
    use LeaveEncashmentValidationRules;

    /** @param LeaveEncashment $model The model to update. @param LeaveEncashmentData $data The replacement data. @return LeaveEncashment The refreshed model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeaveEncashment $model, LeaveEncashmentData $data): LeaveEncashment
    {
        Validator::make($data->toArray(), $this->updateRules($model))->validate();

        return DB::transaction(function () use ($model, $data): LeaveEncashment {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            $model->update($payload);

            return $model->refresh();
        });
    }
}
