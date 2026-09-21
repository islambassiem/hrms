<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\EmployeeSickLeaveCycleValidationRules;
use App\Data\Leave\EmployeeSickLeaveCycleData;
use App\Models\Leave\EmployeeSickLeaveCycle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/** Creates employee sick leave cycles. */
final class EmployeeSickLeaveCycleCreateAction
{
    use EmployeeSickLeaveCycleValidationRules;

    /** @param EmployeeSickLeaveCycleData $data The data to persist. @return EmployeeSickLeaveCycle The created cycle. @throws \Illuminate\Validation\ValidationException */
    public function handle(EmployeeSickLeaveCycleData $data): EmployeeSickLeaveCycle
    {
        Validator::make($data->toArray(), $this->createRules())->validate();

        return DB::transaction(function () use ($data): EmployeeSickLeaveCycle {
            /** @var array<string, mixed> $payload */
            $payload = $data->toArray();

            /** @var EmployeeSickLeaveCycle $employeeSickLeaveCycle */
            $employeeSickLeaveCycle = EmployeeSickLeaveCycle::query()->create($payload);

            return $employeeSickLeaveCycle;
        });
    }
}
