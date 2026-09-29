<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Concerns\UserStamp;
use App\Models\Employee\Employee;
use Database\Factories\Leave\LeaveRequestFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

#[Fillable([
    'leave_type_id',
    'employee_id',
    'start_date',
    'end_date',
    'no_of_days',
    'status',
    'reason',
    'created_by',
    'updated_by',
])]
final class LeaveRequest extends Model
{
    /** @use HasFactory<LeaveRequestFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'start_date' => 'immutable_date',
            'end_date' => 'immutable_date',
        ];
    }

    /**
     * @return BelongsTo<Employee, $this>
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }
}
