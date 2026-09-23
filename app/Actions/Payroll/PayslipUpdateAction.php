<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayslipValidationRules;
use App\Data\Payroll\PayslipData;
use App\Models\Payroll\PayrollPayslip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayslipUpdateAction
{
    use PayslipValidationRules;

    public function handle(PayrollPayslip $payslip, PayslipData $data): PayrollPayslip
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($payslip, $data->run_id),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($payslip, $data, $currentUserId): PayrollPayslip {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $payslip->updated_by,
            ];

            $payslip->update($payload);

            return $payslip->refresh();
        });
    }
}
