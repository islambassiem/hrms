<?php

declare(strict_types=1);

namespace App\Models\Payroll\Salary;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\Salary\EmployeeSalaryComponentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'component_id',
    'amount',
    'effective_from',
    'effective_to',
    'revision_id',
    'created_by',
    'updated_by',
])]
#[Table('payroll_employee_salary_components')]
final class EmployeeSalaryComponent extends Model
{
    /** @use HasFactory<EmployeeSalaryComponentFactory> */
    use HasFactory;

    use UserStamp;
}
