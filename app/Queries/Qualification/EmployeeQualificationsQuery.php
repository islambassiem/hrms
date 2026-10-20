<?php

namespace App\Queries\Qualification;

use App\Models\Employee\Employee;
use App\Models\Qualifications\Qualification;
use Illuminate\Contracts\Database\Eloquent\Builder;

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
        ];
    }

    public function run(?Employee $employee = null): Builder
    {
        return Qualification::query()
            ->with(self::resourceRelations())
            ->when(
                $employee,
                fn (Builder $query) => $query->where('employee_id', $employee?->id),
                fn (Builder $query): Builder => $query,
            );
    }
}
