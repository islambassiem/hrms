<?php

namespace App\Actions\Request\Letter;

use App\Enums\LetterStatusEnum;
use App\Exceptions\CannotDeleteRecord;
use App\Models\Request\Letter;

class DeleteLetterAction
{
    public function handle(Letter $letter): void
    {
        /** @var LetterStatusEnum $status */
        $status = $letter->status;

        if ($status === LetterStatusEnum::DONE) {
            throw new CannotDeleteRecord(
                __('The letter is issued already; you cannot delete it')
            );
        }

        $letter->delete();
    }
}
