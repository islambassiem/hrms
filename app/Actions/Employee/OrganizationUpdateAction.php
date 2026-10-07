<?php

namespace App\Actions\Employee;

use App\Concerns\Employee\OrganizationValidationRules;
use App\Data\Employee\OrganizationData;
use App\Models\Employee\EmployeeOrganization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrganizationUpdateAction
{
    use OrganizationValidationRules;

    public function handle(EmployeeOrganization $employeeOrganization, OrganizationData $data): EmployeeOrganization
    {

        Validator::make(
            $data->toArray(),
            $this->updateRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($employeeOrganization, $data, $currentUserId): EmployeeOrganization {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $employeeOrganization->updated_by,
            ];

            $employeeOrganization->update($payload);

            return $employeeOrganization->refresh();
        });
    }
}
