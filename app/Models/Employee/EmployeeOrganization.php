<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use Database\Factories\Employee\EmployeeOrganizationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'organization_id',
    'start_date',
    'end_date',
    'created_by',
    'updated_by',
])]
#[Table('employee_organizations')]
class EmployeeOrganization extends Model
{
    /** @use HasFactory<EmployeeOrganizationFactory> */
    use HasFactory;

    use UserStamp;

    /** @retun array<string, string> */
    protected function casts(): array
    {
        return [
            'start_date' => 'immutable_date',
            'end_date' => 'immutable_date',
        ];
    }
}
