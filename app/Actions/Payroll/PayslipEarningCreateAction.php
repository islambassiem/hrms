<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayslipEarningValidationRules;
use App\Data\Payroll\PayslipEarningData;
use App\Models\Payroll\PayslipEarning;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayslipEarningCreateAction
{
    use PayslipEarningValidationRules;

    public function handle(PayslipEarningData $data): PayslipEarning
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): PayslipEarning {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var PayslipEarning $payslipEarning */
            $payslipEarning = PayslipEarning::query()->create($payload);

            return $payslipEarning;
        });
    }
}
