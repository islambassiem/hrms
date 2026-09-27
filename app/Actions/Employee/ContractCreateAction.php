<?php

namespace App\Actions\Employee;

use App\Concerns\Employee\ContractValidationRules;
use App\Data\Employee\ContractData;
use App\Models\Employee\EmployeeContract;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ContractCreateAction
{
    use ContractValidationRules;

    public function handle(ContractData $data): EmployeeContract
    {
        Validator::make(
            $data->toArray(),
            $this->rules()
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeContract {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            return EmployeeContract::query()->create($payload);
        });
    }
}
