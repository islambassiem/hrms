<?php

declare(strict_types=1);

namespace App\Models\Payroll;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\PayrollRunFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'period_id',
    'run_type',
    'run_date',
    'status',
    'processed_by',
    'approved_by',
    'approved_at',
    'total_gross',
    'total_deductions',
    'total_net',
    'created_by',
    'updated_by',
])]
#[Table('payroll_runs')]
final class PayrollRun extends Model
{
    /** @use HasFactory<PayrollRunFactory> */
    use HasFactory;

    use UserStamp;
}
