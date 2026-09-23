<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayslipDeductionValidationRules;
use App\Data\Payroll\PayslipDeductionData;
use App\Models\Payroll\PayslipDeduction;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayslipDeductionCreateAction
{
    use PayslipDeductionValidationRules;

    public function handle(PayslipDeductionData $data): PayslipDeduction
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): PayslipDeduction {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var PayslipDeduction $payslipDeduction */
            $payslipDeduction = PayslipDeduction::query()->create($payload);

            return $payslipDeduction;
        });
    }
}
