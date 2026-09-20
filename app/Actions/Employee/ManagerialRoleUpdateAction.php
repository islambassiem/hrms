<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\ManagerialRoleValidationRules;
use App\Data\Employee\ManagerialRoleData;
use App\Models\Employee\EmployeeManagerialRole;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class ManagerialRoleUpdateAction
{
    use ManagerialRoleValidationRules;

    public function handle(EmployeeManagerialRole $managerialRole, ManagerialRoleData $data): EmployeeManagerialRole
    {
        Validator::make(
            $data->toArray(),
            $this->updateRules($managerialRole),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($managerialRole, $data, $currentUserId): EmployeeManagerialRole {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $managerialRole->updated_by,
            ];

            $managerialRole->update($payload);

            return $managerialRole->refresh();
        });
    }
}
