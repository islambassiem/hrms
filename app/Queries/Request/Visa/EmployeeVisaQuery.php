<?php

namespace App\Queries\Request\Visa;

use App\Models\Employee\Employee;
use App\Models\Request\Visa;
use Illuminate\Contracts\Database\Eloquent\Builder;

class EmployeeVisaQuery
{
    public function run(?Employee $employee = null): Builder
    {
        return Visa::query()
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
