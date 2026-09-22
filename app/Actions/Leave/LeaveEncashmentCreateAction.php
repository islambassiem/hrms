<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveEncashmentValidationRules;
use App\Data\Leave\LeaveEncashmentData;
use App\Models\Leave\LeaveEncashment;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates LeaveEncashment records after validation. */
final class LeaveEncashmentCreateAction
{
    use LeaveEncashmentValidationRules;

    /** @param LeaveEncashmentData $data The data to persist. @return LeaveEncashment The created model. @throws \Illuminate\Validation\ValidationException When validation fails. */
    public function handle(LeaveEncashmentData $data): LeaveEncashment
    {
        Validator::make($data->toArray(), $this->createRules())->validate();

        return DB::transaction(function () use ($data): LeaveEncashment {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            /** @var LeaveEncashment $leaveEncashment */
            $leaveEncashment = LeaveEncashment::query()->create($payload);

            return $leaveEncashment;
        });
    }
}
