<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Concerns\UserStamp;
use Database\Factories\Leave\LeavePolicyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'leave_type_id',
    'name_en',
    'name_ar',
    'days_per_year',
    'is_default',
    'accrual_frequency',
    'period_type',
    'allow_accumulation',
    'accumulation_periods',
    'allow_management_carryover',
    'expire_unused',
    'encash_on_termination',
    'pay_rate',
    'created_by',
    'updated_by',
])]
final class LeavePolicy extends Model
{
    /** @use HasFactory<LeavePolicyFactory> */
    use HasFactory;

    use UserStamp;
}
