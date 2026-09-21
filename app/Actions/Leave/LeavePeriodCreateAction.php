<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeavePeriodValidationRules;
use App\Data\Leave\LeavePeriodData;
use App\Models\Leave\LeavePeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates LeavePeriod records after validation. */
final class LeavePeriodCreateAction
{
    use LeavePeriodValidationRules;

    /** @param LeavePeriodData $data The data to persist. @return LeavePeriod The created model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeavePeriodData $data): LeavePeriod
    {
        Validator::make($data->toArray(), $this->createRules())->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): LeavePeriod {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var LeavePeriod $leavePeriod */
            $leavePeriod = LeavePeriod::query()->create($payload);

            return $leavePeriod;
        });
    }
}
