<?php

namespace App\Actions\Payroll\Salary;

use App\Concerns\Payroll\Salary\EmployeeSalaryRevisionValidationRules;
use App\Data\Payroll\Salary\EmployeeSalaryRevisionData;
use App\Models\Payroll\Salary\EmployeeSalaryRevision;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class EmployeeSalaryRevisionUpdateAction
{
    use EmployeeSalaryRevisionValidationRules;

    public function handle(
        EmployeeSalaryRevision $revision,
        EmployeeSalaryRevisionData $data
    ): EmployeeSalaryRevision {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($revision),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($revision, $data, $currentUserId): EmployeeSalaryRevision {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $revision->updated_by,
            ];

            $revision->update($payload);

            return $revision->refresh();
        });
    }
}
