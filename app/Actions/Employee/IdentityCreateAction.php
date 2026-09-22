<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\IdentityValidationRules;
use App\Data\Employee\IdentityData;
use App\Models\Employee\EmployeeIdentity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class IdentityCreateAction
{
    use IdentityValidationRules;

    public function handle(IdentityData $data): EmployeeIdentity
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeIdentity {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeIdentity $identity */
            $identity = EmployeeIdentity::query()->create($payload);

            return $identity;
        });
    }
}
