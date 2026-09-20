<?php

declare(strict_types=1);

namespace App\Models\Payroll;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\PayslipDeductionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'payslip_id',
    'deduction_id',
    'amount',
    'description',
    'created_by',
    'updated_by',
])]
final class PayslipDeduction extends Model
{
    /** @use HasFactory<PayslipDeductionFactory> */
    use HasFactory;

    use UserStamp;
}
