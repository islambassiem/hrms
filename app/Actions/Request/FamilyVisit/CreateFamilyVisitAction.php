<?php

namespace App\Actions\Request\FamilyVisit;

use App\Concerns\Request\FamilyVisitValidationRules;
use App\Data\Request\FamilyVisitData;
use App\Enums\FamilyVisitStatusEnum;
use App\Models\Request\FamilyVisit;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CreateFamilyVisitAction
{
    use FamilyVisitValidationRules;

    public function handle(FamilyVisitData $data): FamilyVisit
    {
        Validator::make(
            $data->toArray(),
            $this->createRules(),
        )->validate();

        /** @var int|null $currentUserId */
        $currentUserId = Auth::id();

        return DB::transaction(function () use ($currentUserId, $data) {
            /** @var array<string, mixed> $payload */
            $payload = [
                ...$data->toArray(),
                'status' => FamilyVisitStatusEnum::PENDING->value,
                'created_by' => $currentUserId,
                'updated_by' => $currentUserId,
            ];

            return FamilyVisit::query()->create($payload);
        });
    }
}
