<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\JobTitleValidationRules;
use App\Data\Employee\JobTitleData;
use App\Models\Employee\EmployeeJobTitle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class JobTitleUpdateAction
{
    use JobTitleValidationRules;

    public function handle(EmployeeJobTitle $jobTitle, JobTitleData $data): EmployeeJobTitle
    {
        Validator::make(
            $data->toArray(),
            $this->updateRules($jobTitle),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($jobTitle, $data, $currentUserId): EmployeeJobTitle {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $jobTitle->updated_by,
            ];

            $jobTitle->update($payload);

            return $jobTitle->refresh();
        });
    }
}
