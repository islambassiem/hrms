<?php

namespace App\Actions\Employee;

use App\Concerns\Employee\OrganizationValidationRules;
use App\Data\Employee\OrganizationData;
use App\Models\Employee\EmployeeOrganization;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class OrganizationCreateAction
{
    use OrganizationValidationRules;

    public function handle(OrganizationData $data): EmployeeOrganization
    {
        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId) {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeOrganization $employeeOrganization */
            $employeeOrganization = EmployeeOrganization::query()->create($payload);

            return $employeeOrganization;
        });

    }
}
