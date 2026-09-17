<?php

declare(strict_types=1);

namespace App\Models\Payroll;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\EmployeeBankFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'bank_id',
    'iban',
    'created_by',
    'updated_by',
])]
#[Table('payroll_employee_banks')]
class EmployeeBank extends Model
{
    /** @use HasFactory<EmployeeBankFactory> */
    use HasFactory;

    use UserStamp;
}
