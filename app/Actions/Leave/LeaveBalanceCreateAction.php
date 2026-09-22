<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveBalanceValidationRules;
use App\Data\Leave\LeaveBalanceData;
use App\Models\Leave\LeaveBalance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates leave balances. */
final class LeaveBalanceCreateAction
{
    use LeaveBalanceValidationRules;

    /** @param LeaveBalanceData $data The balance data. @return LeaveBalance The created balance. @throws \Illuminate\Validation\ValidationException */
    public function handle(LeaveBalanceData $data): LeaveBalance
    {
        Validator::make($data->toArray(), $this->createRules())->validate();

        return DB::transaction(function () use ($data): LeaveBalance {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            /** @var LeaveBalance $leaveBalance */
            $leaveBalance = LeaveBalance::query()->create($payload);

            return $leaveBalance;
        });
    }
}
