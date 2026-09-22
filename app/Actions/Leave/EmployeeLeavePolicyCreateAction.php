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
 * Creates employee leave policy assignments after validating their data.
 */
final class EmployeeLeavePolicyCreateAction
{
    use EmployeeLeavePolicyValidationRules;

    /**
     * Validate and persist a new employee leave policy assignment.
     *
     * @param  EmployeeLeavePolicyData  $data  The assignment data to validate and persist.
     * @return EmployeeLeavePolicy The newly persisted employee leave policy assignment.
     *
     * @throws ValidationException When the assignment data is invalid.
     */
    public function handle(EmployeeLeavePolicyData $data): EmployeeLeavePolicy
    {
        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeLeavePolicy {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeLeavePolicy $employeeLeavePolicy */
            $employeeLeavePolicy = EmployeeLeavePolicy::query()->create($payload);

            return $employeeLeavePolicy;
        });
    }
}
