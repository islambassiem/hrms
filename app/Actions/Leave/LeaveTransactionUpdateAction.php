<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveTransactionValidationRules;
use App\Data\Leave\LeaveTransactionData;
use App\Models\Leave\LeaveTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates leave transactions. */
final class LeaveTransactionUpdateAction
{
    use LeaveTransactionValidationRules;

    /** @param LeaveTransaction $leaveTransaction The transaction to update. @param LeaveTransactionData $data The replacement data. @return LeaveTransaction The refreshed transaction. @throws \Illuminate\Validation\ValidationException */
    public function handle(LeaveTransaction $leaveTransaction, LeaveTransactionData $data): LeaveTransaction
    {
        Validator::make($data->toArray(), $this->updateRules($leaveTransaction))->validate();

        return DB::transaction(function () use ($leaveTransaction, $data): LeaveTransaction {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            $leaveTransaction->update($payload);

            return $leaveTransaction->refresh();
        });
    }
}
