<?php

namespace App\Queries\Request\FamilyVisit;

use App\Models\Employee\Employee;
use App\Models\Request\FamilyVisit;
use Illuminate\Database\Eloquent\Builder;

class FamilyVisitQuery
{
    /**
     * @return Builder<FamilyVisit>
     */
    public function run(?Employee $employee = null): Builder
    {
        return FamilyVisit::query()
            ->with($this->resourceRelations())
            ->when(
                $employee,
                fn ($query) => $query->where('employee_id', $employee?->id),
            );
    }

    /**
     * @return list<string>
     */
    private function resourceRelations(): array
    {
        return [
            'employee',
        ];
    }
}
