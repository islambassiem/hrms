<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayslipEarningValidationRules;
use App\Data\Payroll\PayslipEarningData;
use App\Models\Payroll\PayslipEarning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayslipEarningUpdateAction
{
    use PayslipEarningValidationRules;

    public function handle(PayslipEarning $payslipEarning, PayslipEarningData $data): PayslipEarning
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($payslipEarning),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($payslipEarning, $data, $currentUserId): PayslipEarning {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $payslipEarning->updated_by,
            ];

            $payslipEarning->update($payload);

            return $payslipEarning->refresh();
        });
    }
}
