<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\EmployeeBankValidationRules;
use App\Data\Payroll\EmployeeBankData;
use App\Models\Payroll\EmployeeBank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class EmployeeBankCreateAction
{
    use EmployeeBankValidationRules;

    public function handle(EmployeeBankData $data): EmployeeBank
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeBank {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeBank $employeeBank */
            $employeeBank = EmployeeBank::query()->create($payload);

            return $employeeBank;
        });
    }
}
