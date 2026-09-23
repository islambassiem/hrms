<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\PayrollRunValidationRules;
use App\Data\Payroll\PayrollRunData;
use App\Models\Payroll\PayrollRun;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class PayrollRunCreateAction
{
    use PayrollRunValidationRules;

    public function handle(PayrollRunData $data): PayrollRun
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): PayrollRun {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var PayrollRun $run */
            $run = PayrollRun::query()->create($payload);

            return $run;
        });
    }
}
