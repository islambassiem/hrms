<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PeriodValidationRules;
use App\Data\Payroll\PeriodData;
use App\Models\Payroll\PayrollPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PeriodUpdateAction
{
    use PeriodValidationRules;

    public function handle(PayrollPeriod $period, PeriodData $data): PayrollPeriod
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($period),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($period, $data, $currentUserId): PayrollPeriod {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $period->updated_by,
            ];

            $period->update($payload);

            return $period->refresh();
        });
    }
}
