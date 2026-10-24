<?php

namespace App\Actions\Request\FamilyVisit;

use App\Concerns\Request\FamilyVisitValidationRules;
use App\Data\Request\FamilyVisitData;
use App\Enums\FamilyVisitStatusEnum;
use App\Exceptions\CannotUpdateRecord;
use App\Models\Request\FamilyVisit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UpdateFamilyVisitAction
{
    use FamilyVisitValidationRules;

    public function handle(FamilyVisit $familyVisit, FamilyVisitData $data): FamilyVisit
    {
        if ($familyVisit->status === FamilyVisitStatusEnum::ATTESTED) {
            throw new CannotUpdateRecord(
                __('Cannot update the family visit after attestation')
            );
        }

        Validator::make(
            $data->toArray(),
            $this->updateRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($familyVisit, $data, $currentUserId): FamilyVisit {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'updated_by' => $currentUserId ?? $familyVisit->updated_by,
            ];

            $familyVisit->update($payload);

            return $familyVisit->refresh();
        });
    }
}
