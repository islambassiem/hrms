<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\EmployeeValidationRules;
use App\Data\Employee\EmployeeData;
use App\Models\Employee\Employee;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class EmployeeCreateAction
{
    use EmployeeValidationRules;

    public function handle(EmployeeData $data): Employee
    {

        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): Employee {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var Employee $employee */
            $employee = Employee::query()->create($payload);

            return $employee;
        });
    }
}
