<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\SickLeaveRuleValidationRules;
use App\Data\Leave\SickLeaveRuleData;
use App\Models\Leave\SickLeaveRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates SickLeaveRule records after validation. */
final class SickLeaveRuleUpdateAction
{
    use SickLeaveRuleValidationRules;

    /** @param SickLeaveRule $model The model to update. @param SickLeaveRuleData $data The replacement data. @return SickLeaveRule The refreshed model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(SickLeaveRule $model, SickLeaveRuleData $data): SickLeaveRule
    {
        Validator::make($data->toArray(), $this->updateRules($model))->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($model, $data, $currentUserId): SickLeaveRule {
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
