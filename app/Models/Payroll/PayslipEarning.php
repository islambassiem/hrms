<?php

declare(strict_types=1);

namespace App\Models\Payroll;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\PayslipEarningFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'payslip_id',
    'earning_id',
    'item_type',
    'amount',
    'description',
    'created_by',
    'updated_by',
])]
final class PayslipEarning extends Model
{
    /** @use HasFactory<PayslipEarningFactory> */
    use HasFactory;

    use UserStamp;
}
