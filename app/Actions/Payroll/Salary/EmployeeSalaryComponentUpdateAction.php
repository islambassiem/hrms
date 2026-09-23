<?php

namespace App\Actions\Payroll\Salary;

use App\Concerns\Payroll\Salary\EmployeeSalaryComponentValidationRules;
use App\Data\Payroll\Salary\EmployeeSalaryComponentData;
use App\Models\Payroll\Salary\EmployeeSalaryComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class EmployeeSalaryComponentUpdateAction
{
    use EmployeeSalaryComponentValidationRules;

    public function handle(
        EmployeeSalaryComponent $component,
        EmployeeSalaryComponentData $data
    ): EmployeeSalaryComponent {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($component),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($component, $data, $currentUserId): EmployeeSalaryComponent {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $component->updated_by,
            ];

            $component->update($payload);

            return $component->refresh();
        });
    }
}
