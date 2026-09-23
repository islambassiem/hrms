<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Concerns\UserStamp;
use Database\Factories\Leave\EmployeeLeavePolicyFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'leave_policy_id',
    'start_date',
    'end_date',
    'created_by',
    'updated_by',
])]
#[Table('leave_employee_policies')]
final class EmployeeLeavePolicy extends Model
{
    /** @use HasFactory<EmployeeLeavePolicyFactory> */
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
}
