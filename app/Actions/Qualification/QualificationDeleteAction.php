<?php

namespace App\Actions\Qualification;

use App\Exceptions\CannotDeleteRecord;
use App\Models\Qualifications\Qualification;

class QualificationDeleteAction
{
    public function handle(Qualification $qualification): void
    {
        $hasOtherQualifications = Qualification::query()
            ->where('employee_id', $qualification->employee_id)
            ->where('id', '!=', $qualification->id)
            ->exists();

        if (! $hasOtherQualifications) {
            throw new CannotDeleteRecord(
                __('Employee should have at lease one qualification')
            );
        }

        $qualification->delete();

    }
}
