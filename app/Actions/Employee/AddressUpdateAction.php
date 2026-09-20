<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\AddressValidationRules;
use App\Data\Employee\AddressData;
use App\Models\Employee\EmployeeAddress;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class AddressUpdateAction
{
    use AddressValidationRules;

    public function handle(EmployeeAddress $address, AddressData $data): EmployeeAddress
    {
        Validator::make(
            $data->toArray(),
            $this->updateRules($address),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($address, $data, $currentUserId): EmployeeAddress {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $address->updated_by,
            ];

            $address->update($payload);

            return $address->refresh();
        });
    }
}
