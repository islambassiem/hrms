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
class ShortLeaveRequest extends Model
{
    /** @use HasFactory<ShortLeaveRequestFactory> */
    use HasFactory;

    use UserStamp;
}
