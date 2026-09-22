<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\IdentityValidationRules;
use App\Data\Employee\IdentityData;
use App\Models\Employee\EmployeeIdentity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class IdentityUpdateAction
{
    use IdentityValidationRules;

    public function handle(EmployeeIdentity $identity, IdentityData $data): EmployeeIdentity
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($identity),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($identity, $data, $currentUserId): EmployeeIdentity {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $identity->updated_by,
            ];

            $identity->update($payload);

            return $identity->refresh();
        });
    }
}
