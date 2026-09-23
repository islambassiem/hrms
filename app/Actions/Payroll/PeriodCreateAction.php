<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PeriodValidationRules;
use App\Data\Payroll\PeriodData;
use App\Models\Payroll\PayrollPeriod;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PeriodCreateAction
{
    use PeriodValidationRules;

    public function handle(PeriodData $data): PayrollPeriod
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): PayrollPeriod {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var PayrollPeriod $period */
            $period = PayrollPeriod::query()->create($payload);

            return $period;
        });
    }
}
