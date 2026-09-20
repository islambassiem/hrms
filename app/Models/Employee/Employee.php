<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use Database\Factories\Employee\EmployeeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'user_id',
    'head_id',
    'employee_code',
    'first_name_ar',
    'middle_name_ar',
    'third_name_ar',
    'last_name_ar',
    'first_name_en',
    'middle_name_en',
    'third_name_en',
    'last_name_en',
    'marital_status_id',
    'religion_id',
    'special_need_id',
    'gender_id',
    'category_id',
    'department_id',
    'nationality_id',
    'place_of_birth_id',
    'email',
    'phone',
    'image',
    'date_of_birth',
    'joining_date',
    'leaving_date',
    'home_telephone_number',
    'home_country_identity',
    'blood_type',
    'is_active',
    'created_by',
    'updated_by',
])]
/** @use UserStamp<Employee> */
final class Employee extends Model
{
    /** @use HasFactory<EmployeeFactory> */
    use HasFactory;

    use UserStamp;

    /** @retun array<string, string> */
    public function casts(): array
    {
        return [
            'date_of_birth' => 'immutable_date',
            'joining_date' => 'immutable_date',
            'leaving_date' => 'immutable_date',
        ];
    }
}
