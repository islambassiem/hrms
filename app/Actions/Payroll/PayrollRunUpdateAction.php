<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayrollRunValidationRules;
use App\Data\Payroll\PayrollRunData;
use App\Models\Payroll\PayrollRun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayrollRunUpdateAction
{
    use PayrollRunValidationRules;

    public function handle(PayrollRun $run, PayrollRunData $data): PayrollRun
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($run),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($run, $data, $currentUserId): PayrollRun {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $run->updated_by,
            ];

            $run->update($payload);

            return $run->refresh();
        });
    }
}
