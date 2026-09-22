<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\EmployeeSickLeaveCycleValidationRules;
use App\Data\Leave\EmployeeSickLeaveCycleData;
use App\Models\Leave\EmployeeSickLeaveCycle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Updates employee sick leave cycles. */
final class EmployeeSickLeaveCycleUpdateAction
{
    use EmployeeSickLeaveCycleValidationRules;

    /** @param EmployeeSickLeaveCycle $employeeSickLeaveCycle The cycle to update. @param EmployeeSickLeaveCycleData $data The replacement data. @return EmployeeSickLeaveCycle The refreshed cycle. @throws \Illuminate\Validation\ValidationException */
    public function handle(EmployeeSickLeaveCycle $employeeSickLeaveCycle, EmployeeSickLeaveCycleData $data): EmployeeSickLeaveCycle
    {
        Validator::make($data->toArray(), $this->updateRules($employeeSickLeaveCycle))->validate();

        return DB::transaction(function () use ($employeeSickLeaveCycle, $data): EmployeeSickLeaveCycle {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            $employeeSickLeaveCycle->update($payload);

            return $employeeSickLeaveCycle->refresh();
        });
    }
}
