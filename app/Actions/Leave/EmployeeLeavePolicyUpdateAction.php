<?php

declare(strict_types=1);

namespace App\Actions\Leave;

use App\Concerns\Leave\EmployeeLeavePolicyValidationRules;
use App\Data\Leave\EmployeeLeavePolicyData;
use App\Models\Leave\EmployeeLeavePolicy;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

/**
 * Updates employee leave policy assignments after validating their data.
 */
final class EmployeeLeavePolicyUpdateAction
{
    use EmployeeLeavePolicyValidationRules;

    /**
     * Validate and update an existing employee leave policy assignment.
     *
     * @param  EmployeeLeavePolicy  $employeeLeavePolicy  The assignment to update.
     * @param  EmployeeLeavePolicyData  $data  The replacement assignment data.
     * @return EmployeeLeavePolicy The refreshed employee leave policy assignment.
     *
     * @throws ValidationException When the assignment data is invalid.
     */
    public function handle(
        EmployeeLeavePolicy $employeeLeavePolicy,
        EmployeeLeavePolicyData $data,
    ): EmployeeLeavePolicy {
        Validator::make(
            $data->toArray(),
            $this->updateRules($employeeLeavePolicy),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($employeeLeavePolicy, $data, $currentUserId): EmployeeLeavePolicy {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $employeeLeavePolicy->updated_by,
            ];

            $employeeLeavePolicy->update($payload);

            return $employeeLeavePolicy->refresh();
        });
    }
}
