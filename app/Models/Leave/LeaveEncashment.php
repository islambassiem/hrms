<?php

declare(strict_types=1);

namespace App\Models\Leave;

use Database\Factories\Leave\LeaveEncashmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'leave_type_id',
    'leave_entitlement_id',
    'days',
    'daily_rate',
    'amount',
    'status',
    'reason',
    'approved_by',
    'approved_at',
    'processed_at',
    'payroll_reference',
])]
class LeaveEncashment extends Model
{
    /** @use HasFactory<LeaveEncashmentFactory> */
    use HasFactory;
}
