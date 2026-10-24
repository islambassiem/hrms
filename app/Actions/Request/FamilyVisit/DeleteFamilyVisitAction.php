<?php

namespace App\Actions\Request\FamilyVisit;

use App\Enums\FamilyVisitStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Models\Request\FamilyVisit;

class DeleteFamilyVisitAction
{
    public function handle(FamilyVisit $familyVisit): void
    {
        /** @var FamilyVisitStatusEnum $status */
        $status = $familyVisit->status;

        if ($status === FamilyVisitStatusEnum::ATTESTED) {
            throw new CannotDeleteRecord(
                __('The visit is attested already; you cannot delete it')
            );
        }

        $familyVisit->delete();
    }
}
