<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeavePeriodValidationRules;
use App\Data\Leave\LeavePeriodData;
use App\Models\Leave\LeavePeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates LeavePeriod records after validation. */
final class LeavePeriodUpdateAction
{
    use LeavePeriodValidationRules;

    /** @param LeavePeriod $model The model to update. @param LeavePeriodData $data The replacement data. @return LeavePeriod The refreshed model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeavePeriod $model, LeavePeriodData $data): LeavePeriod
    {
        Validator::make($data->toArray(), $this->updateRules($model))->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($model, $data, $currentUserId): LeavePeriod {
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
