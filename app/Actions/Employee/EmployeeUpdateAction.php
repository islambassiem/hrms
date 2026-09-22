<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\EmployeeValidationRules;
use App\Data\Employee\EmployeeData;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use LogicException;

final class EmployeeUpdateAction
{
    use EmployeeValidationRules;

    public function handle(Employee $employee, EmployeeData $data): Employee
    {
        Validator::make(
            $data->toArray(),
            $this->updateRules($employee),
        )->validate();

        /** @var int|string|null $currentUserId */
        $currentUserId = Auth::id();

        throw_if($currentUserId !== null && ! \is_int($currentUserId), LogicException::class, 'The authenticated user ID must be an integer.');

        return DB::transaction(function () use (
            $employee,
            $data,
            $currentUserId
        ): Employee {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $employee->updated_by,
            ];

            $employee->update($payload);

            return $employee->refresh();
        });
    }
}
