<?php

declare(strict_types=1);

namespace App\Models\Leave;

use Database\Factories\Leave\LeaveEntitlementFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'leave_type_id',
    'leave_policy_id',
    'leave_period_id',
    'entitled_days',
    'accrued_days',
    'used_days',
    'expired_days',
    'encashed_days',
    'expires_at',
    'status',
])]
final class LeaveEntitlement extends Model
{
    /** @use HasFactory<LeaveEntitlementFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'expires_at' => 'immutable_date',
        ];
    }
}
