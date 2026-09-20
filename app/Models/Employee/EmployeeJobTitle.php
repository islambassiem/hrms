<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use Database\Factories\Employee\EmployeeJobTitleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'job_title_id',
    'start_date',
    'end_date',
    'created_by',
    'updated_by',
])]
final class EmployeeJobTitle extends Model
{
    /** @use HasFactory<EmployeeJobTitleFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array<string, string>
     */
    public function casts(): array
    {
        return [
            'start_date' => 'immutable_date',
            'end_date' => 'immutable_date',
        ];
    }
}
