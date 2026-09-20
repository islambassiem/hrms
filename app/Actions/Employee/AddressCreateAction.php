<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\AddressValidationRules;
use App\Data\Employee\AddressData;
use App\Models\Employee\EmployeeAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class AddressCreateAction
{
    use AddressValidationRules;

    public function handle(AddressData $data): EmployeeAddress
    {
        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeAddress {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeAddress $address */
            $address = EmployeeAddress::query()->create($payload);

            return $address;
        });
    }
}
