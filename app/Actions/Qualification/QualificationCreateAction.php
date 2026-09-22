<?php

namespace App\Actions\Qualification;

use App\Concerns\Qualification\QualificationValidationRules;
use App\Data\Qualification\QualificationData;
use App\Models\Qualifications\Qualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QualificationCreateAction
{
    use QualificationValidationRules;

    public function handle(QualificationData $data): Qualification
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($data, $currentUserId): Qualification {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            /** @var Qualification $qualification */
            $qualification = Qualification::query()->create($payload);

            return $qualification;
        });
    }
}
