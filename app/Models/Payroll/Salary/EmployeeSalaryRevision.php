<?php

declare(strict_types=1);

namespace App\Models\Payroll\Salary;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\Salary\EmployeeSalaryRevisionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'revision_type_id',
    'effective_date',
    'previous_gross',
    'new_gross',
    'reason',
    'created_by',
    'updated_by',
])]
#[Table('payroll_employee_salary_revisions')]
final class EmployeeSalaryRevision extends Model
{
    /** @use HasFactory<EmployeeSalaryRevisionFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'effective_date' => 'immutable_date',
        ];
    }
}
