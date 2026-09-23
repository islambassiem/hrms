<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayslipDeductionValidationRules;
use App\Data\Payroll\PayslipDeductionData;
use App\Models\Payroll\PayslipDeduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayslipDeductionUpdateAction
{
    use PayslipDeductionValidationRules;

    public function handle(PayslipDeduction $payslipDeduction, PayslipDeductionData $data): PayslipDeduction
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($payslipDeduction),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($payslipDeduction, $data, $currentUserId): PayslipDeduction {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $payslipDeduction->updated_by,
            ];

            $payslipDeduction->update($payload);

            return $payslipDeduction->refresh();
        });
    }
}
