<?php

declare(strict_types=1);

namespace App\Actions\Employee;

use App\Concerns\Employee\JobTitleValidationRules;
use App\Data\Employee\JobTitleData;
use App\Models\Employee\EmployeeJobTitle;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

final class JobTitleCreateAction
{
    use JobTitleValidationRules;

    public function handle(JobTitleData $data): EmployeeJobTitle
    {
        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): EmployeeJobTitle {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var EmployeeJobTitle $jobTitle */
            $jobTitle = EmployeeJobTitle::query()->create($payload);

            return $jobTitle;
        });
    }
}
