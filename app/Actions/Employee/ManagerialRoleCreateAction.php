<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\ManagerialRoleValidationRules;
use App\Data\Employee\ManagerialRoleData;
use App\Models\Employee\EmployeeManagerialRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class ManagerialRoleCreateAction
{
    use ManagerialRoleValidationRules;

    public function handle(ManagerialRoleData $data): EmployeeManagerialRole
    {
        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeManagerialRole {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeManagerialRole $managerialRole */
            $managerialRole = EmployeeManagerialRole::query()->create($payload);

            return $managerialRole;
        });
    }
}
