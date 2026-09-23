<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use Database\Factories\Employee\EmployeeIdentityFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'identity_type_id',
    'identity_number',
    'place_of_issue',
    'issue_date',
    'expiry_date',
    'created_by',
    'updated_by',
])]
final class EmployeeIdentity extends Model
{
    /** @use HasFactory<EmployeeIdentityFactory> */
    use HasFactory;

    use UserStamp;

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'issue_date' => 'immutable_date',
            'expiry_date' => 'immutable_date',
        ];
    }
}
