<?php

declare(strict_types=1);

namespace App\Models\Leave;

use Database\Factories\Leave\LeaveCarryoverFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'leave_type_id',
    'from_period_id',
    'to_period_id',
    'source_entitlement_id',
    'target_entitlement_id',
    'requested_days',
    'approved_days',
    'status',
    'reason',
    'requested_by',
    'approved_by',
    'requested_at',
    'approved_at',
    'expires_at',
])]
final class LeaveCarryover extends Model
{
    /** @use HasFactory<LeaveCarryoverFactory> */
    use HasFactory;
}
