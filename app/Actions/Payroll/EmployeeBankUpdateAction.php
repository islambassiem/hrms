<?php

namespace App\Actions\Payroll;

use App\Concerns\Payroll\EmployeeBankValidationRules;
use App\Data\Payroll\EmployeeBankData;
use App\Models\Payroll\EmployeeBank;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class EmployeeBankUpdateAction
{
    use EmployeeBankValidationRules;

    public function handle(EmployeeBank $employeeBank, EmployeeBankData $data): EmployeeBank
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($employeeBank),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($employeeBank, $data, $currentUserId): EmployeeBank {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $employeeBank->updated_by,
            ];

            $employeeBank->update($payload);

            return $employeeBank->refresh();
        });
    }
}
