<?php

declare(strict_types=1);

namespace App\Models\Employees;

use App\Concerns\UserStamp;
use Database\Factories\Employees\EmployeeIdentityFactory;
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
class EmployeeIdentity extends Model
{
    /** @use HasFactory<EmployeeIdentityFactory> */
    use HasFactory;

    use UserStamp;
}
