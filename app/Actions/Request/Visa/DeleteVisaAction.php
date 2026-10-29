<?php

namespace App\Actions\Request\Visa;

use App\Enums\VisaStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Models\Request\Visa;

class DeleteVisaAction
{
    public function handle(Visa $visa): void
    {
        if ($visa->status !== VisaStatusEnum::PENDING) {
            throw new CannotDeleteRecord(
                __('Cannot delete a visa unless it is pending')
            );
        }

        $visa->delete();
    }
}
