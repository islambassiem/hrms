<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\DependentValidationRules;
use App\Data\Employee\DependentData;
use App\Models\Employee\EmployeeDependent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class DependentCreateAction
{
    use DependentValidationRules;

    public function handle(DependentData $data): EmployeeDependent
    {
        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeDependent {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeDependent $dependent */
            $dependent = EmployeeDependent::query()->create($payload);

            return $dependent;
        });
    }
}
