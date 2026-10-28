<?php

namespace App\Actions\Request\Visa;

use App\Enums\VisaStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Models\Request\Visa;

class DeleteVisaAction
{
    public function handle(Visa $visa): void
    {
        if ($visa->status === VisaStatusEnum::ISSUED) {
            throw new CannotDeleteRecord(
                __('Cannot delete the visa after issuing')
            );
        }

        $visa->delete();
    }
}
