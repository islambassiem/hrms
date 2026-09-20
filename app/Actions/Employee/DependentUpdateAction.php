<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\DependentValidationRules;
use App\Data\Employee\DependentData;
use App\Models\Employee\EmployeeDependent;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class DependentUpdateAction
{
    use DependentValidationRules;

    public function handle(EmployeeDependent $dependent, DependentData $data): EmployeeDependent
    {
        Validator::make(
            $data->toArray(),
            $this->updateRules($dependent),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($dependent, $data, $currentUserId): EmployeeDependent {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $dependent->updated_by,
            ];

            $dependent->update($payload);

            return $dependent->refresh();
        });
    }
}
