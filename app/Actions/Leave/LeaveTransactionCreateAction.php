<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\LeaveTransactionValidationRules;
use App\Data\Leave\LeaveTransactionData;
use App\Models\Leave\LeaveTransaction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates leave transactions. */
final class LeaveTransactionCreateAction
{
    use LeaveTransactionValidationRules;

    /** @param LeaveTransactionData $data The transaction data. @return LeaveTransaction The created transaction. @throws \Illuminate\Validation\ValidationException */
    public function handle(LeaveTransactionData $data): LeaveTransaction
    {
        Validator::make($data->toArray(), $this->createRules())->validate();
        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): LeaveTransaction {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
            ];

            /** @var LeaveTransaction $leaveTransaction */
            $leaveTransaction = LeaveTransaction::query()->create($payload);

            return $leaveTransaction;
        });
    }
}
