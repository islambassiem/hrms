<?php

namespace App\Queries\Qualification;

use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use Illuminate\Database\Eloquent\Builder;

class EmployeeQualificationsQuery
{
    /**
     * @return list<string>
     */
    public static function resourceRelations(): array
    {
        return [
            'major',
            'minor',
            'educationalSublevel',
            'includedSpecialty',
            'scientificDegree',
            'graduationCountry',
            'rating',
            'gpaType',
            'studyType',
            'media',
        ];
    }

    /**
     * @return Builder<Qualification>
     */
    public function run(?Employee $employee = null): Builder
    {
        return Qualification::query()
            ->with(self::resourceRelations())
            ->when(
                $employee !== null,
                fn ($query) => $query->where('employee_id', $employee?->id),
            )
            ->latest('graduation_date')
            ->orderByDesc('id');
    }
}
