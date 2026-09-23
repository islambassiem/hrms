<?php

namespace App\Actions\Payroll\Salary;

use App\Concerns\Payroll\Salary\EmployeeSalaryRevisionValidationRules;
use App\Data\Payroll\Salary\EmployeeSalaryRevisionData;
use App\Models\Payroll\Salary\EmployeeSalaryRevision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class EmployeeSalaryRevisionCreateAction
{
    use EmployeeSalaryRevisionValidationRules;

    public function handle(EmployeeSalaryRevisionData $data): EmployeeSalaryRevision
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeSalaryRevision {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeSalaryRevision $revision */
            $revision = EmployeeSalaryRevision::query()->create($payload);

            return $revision;
        });
    }
}
