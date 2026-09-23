<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayslipValidationRules;
use App\Data\Payroll\PayslipData;
use App\Models\Payroll\PayrollPayslip;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayslipCreateAction
{
    use PayslipValidationRules;

    public function handle(PayslipData $data): PayrollPayslip
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules($data->run_id),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): PayrollPayslip {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var PayrollPayslip $payslip */
            $payslip = PayrollPayslip::query()->create($payload);

            return $payslip;
        });
    }
}
