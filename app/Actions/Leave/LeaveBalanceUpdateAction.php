<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveBalanceValidationRules;
use App\Data\Leave\LeaveBalanceData;
use App\Models\Leave\LeaveBalance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates leave balances. */
final class LeaveBalanceUpdateAction
{
    use LeaveBalanceValidationRules;

    /** @param LeaveBalance $leaveBalance The balance to update. @param LeaveBalanceData $data The replacement data. @return LeaveBalance The refreshed balance. @throws \Illuminate\Validation\ValidationException */
    public function handle(LeaveBalance $leaveBalance, LeaveBalanceData $data): LeaveBalance
    {
        Validator::make($data->toArray(), $this->updateRules($leaveBalance))->validate();

        return DB::transaction(function () use ($leaveBalance, $data): LeaveBalance {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            $leaveBalance->update($payload);

            return $leaveBalance->refresh();
        });
    }
}
