<?php

namespace App\Queries\Request\Letter;

use App\Models\Employee\Employee;
use App\Models\Request\Letter;
use Illuminate\Database\Eloquent\Builder;

class EmployeeLetterQuery
{
    /**
     * @return Builder<Letter>
     */
    public function run(?Employee $employee = null): Builder
    {
        return Letter::query()
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
