<?php

declare(strict_types=1);

namespace App\Models\Leave;

use Database\Factories\Leave\LeaveTransactionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'leave_type_id',
    'leave_entitlement_id',
    'leave_request_id',
    'transaction_type',
    'days',
    'transaction_date',
    'start_date',
    'end_date',
    'balance_after',
    'pay_rate',
    'expires_at',
    'payroll_processed_at',
    'reference_type',
    'reference_id',
    'created_by',
])]
final class LeaveTransaction extends Model
{
    /** @use HasFactory<LeaveTransactionFactory> */
    use HasFactory;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'immutable_date',
            'end_date' => 'immutable_date',
            'expires_at' => 'immutable_date',
            'payroll_processed_at' => 'immutable_date',
        ];
    }
}
