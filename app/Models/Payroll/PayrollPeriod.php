<?php

declare(strict_types=1);

namespace App\Models\Payroll;

use App\Concerns\UserStamp;
use Database\Factories\Payroll\PayrollPeriodFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable(
    'name',
    'start_date',
    'end_date',
    'pay_date',
    'status',
    'created_by',
    'updated_by',
)]
#[Table('payroll_periods')]
final class PayrollPeriod extends Model
{
    /** @use HasFactory<PayrollPeriodFactory> */
    use HasFactory;

    use UserStamp;

    protected function casts()
    {
        return [
            'start_date' => 'immutable_date',
            'end_date' => 'immutable_date',
            'pay_date' => 'immutable_date',
        ];
    }
}
