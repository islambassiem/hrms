<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use Database\Factories\Employee\EmployeeAddressFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'short_address',
    'building_number',
    'street',
    'secondary_number',
    'district',
    'postal_code',
    'city',
    'created_by',
    'updated_by',
])]

final class EmployeeAddress extends Model
{
    /** @use HasFactory<EmployeeAddressFactory> */
    use HasFactory;

    use UserStamp;
}
