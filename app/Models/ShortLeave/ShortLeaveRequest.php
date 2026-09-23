<?php

declare(strict_types=1);

namespace App\Models\ShortLeave;

use App\Concerns\UserStamp;
use Database\Factories\ShortLeave\ShortLeaveRequestFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'short_leave_type_id',
    'short_leave_date',
    'short_leave_from',
    'short_leave_to',
    'status',
    'created_by',
    'updated_by',
])]
final class ShortLeaveRequest extends Model
{
    /** @use HasFactory<ShortLeaveRequestFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'short_leave_date' => 'immutable_date',
            'short_leave_from' => 'immutable_datetime',
            'short_leave_to' => 'immutable_datetime',
        ];
    }
}
