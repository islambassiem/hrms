<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\SickLeaveRuleValidationRules;
use App\Data\Leave\SickLeaveRuleData;
use App\Models\Leave\SickLeaveRule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates SickLeaveRule records after validation. */
final class SickLeaveRuleCreateAction
{
    use SickLeaveRuleValidationRules;

    /** @param SickLeaveRuleData $data The data to persist. @return SickLeaveRule The created model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(SickLeaveRuleData $data): SickLeaveRule
    {
        Validator::make($data->toArray(), $this->createRules())->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): SickLeaveRule {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var SickLeaveRule $sickLeaveRule */
            $sickLeaveRule = SickLeaveRule::query()->create($payload);

            return $sickLeaveRule;
        });
    }
}
