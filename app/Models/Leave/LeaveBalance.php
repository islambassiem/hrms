<?php

declare(strict_types=1);

namespace App\Models\Leave;

use Database\Factories\Leave\LeaveBalanceFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'leave_type_id',
    'available_days',
    'accrued_days',
    'used_days',
    'pending_days',
    'expiring_days',
    'next_expiry_date',
])]
class LeaveBalance extends Model
{
    /** @use HasFactory<LeaveBalanceFactory> */
    use HasFactory;
}
