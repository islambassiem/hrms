<?php

namespace App\Actions\Qualification;

use App\Concerns\Qualification\QualificationValidationRules;
use App\Data\Qualification\QualificationData;
use App\Models\Qualifications\Qualification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class QualificationUpdateAction
{
    use QualificationValidationRules;

    public function handle(Qualification $qualification, QualificationData $data): Qualification
    {
        Validator::make(
            $data->toArray(),
            /** @var array<string, mixed> */
            $this->updateRules($qualification),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($qualification, $data, $currentUserId): Qualification {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $qualification->updated_by,
            ];

            $qualification->update($payload);

            return $qualification->refresh();
        });
    }
}
