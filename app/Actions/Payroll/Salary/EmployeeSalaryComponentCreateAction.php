<?php

namespace App\Actions\Payroll\Salary;

use App\Concerns\Payroll\Salary\EmployeeSalaryComponentValidationRules;
use App\Data\Payroll\Salary\EmployeeSalaryComponentData;
use App\Models\Payroll\Salary\EmployeeSalaryComponent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class EmployeeSalaryComponentCreateAction
{
    use EmployeeSalaryComponentValidationRules;

    public function handle(EmployeeSalaryComponentData $data): EmployeeSalaryComponent
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeSalaryComponent {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeSalaryComponent $component */
            $component = EmployeeSalaryComponent::query()->create($payload);

            return $component;
        });
    }
}
