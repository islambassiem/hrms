<?php

declare(strict_types=1);

namespace App\Models\Payroll;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\PayrollPayslipFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'run_id',
    'employee_id',
    'salary_revision_id',
    'salary_structure_id',
    'days_worked',
    'gross_earnings',
    'total_deductions',
    'net_pay',
    'status',
    'remarks',
    'created_by',
    'updated_by',
])]
final class PayrollPayslip extends Model
{
    /** @use HasFactory<PayrollPayslipFactory> */
    use HasFactory;

    use UserStamp;
}
