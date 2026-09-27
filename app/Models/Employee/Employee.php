<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use App\Enums\LeaveTypeEnum;
use App\Models\Leave\LeaveBalance;
use App\Models\Lookup\Department;
use App\Models\Payroll\Salary\EmployeeSalaryRevision;
use Database\Factories\Employee\EmployeeFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

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
    protected function casts(): array
    {
        return [
            'date_of_birth' => 'immutable_date',
            'joining_date' => 'immutable_date',
            'leaving_date' => 'immutable_date',
        ];
    }

    /**
     * @return Attribute<string, never>
     */
    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn (): string => match (app()->getLocale()) {
                'ar' => "{$this->first_name_ar} {$this->middle_name_ar} {$this->third_name_ar} {$this->last_name_ar}",
                default => "{$this->first_name_en} {$this->middle_name_en} {$this->third_name_en} {$this->last_name_en}"
            },
        );
    }

    /**
     * @return HasMany<EmployeeJobTitle, $this>
     */
    public function jobTitles(): HasMany
    {
        return $this->hasMany(EmployeeJobTitle::class);
    }

    /**
     * @return HasMany<EmployeeJobTitle, $this>
     */
    public function currentJobTitles(): HasMany
    {
        return $this->jobTitles()
            ->whereNull('end_date');
    }

    /**
     * @return HasOne<EmployeeJobTitle, $this>
     */
    public function latestCurrentJobTitle(): HasOne
    {
        return $this->currentJobTitles()
            ->one()
            ->latestOfMany('start_date');
    }

    /**
     * @return BelongsTo<Department, $this>
     */
    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    /**
     * @return BelongsTo<Employee, $this>
     */
    public function head(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    /**
     * @return HasOne<LeaveBalance, $this>
     */
    public function annualLeaveBalance(): HasOne
    {
        return $this->hasOne(LeaveBalance::class)
            ->where('leave_type_id', LeaveTypeEnum::ANNUAL->value);
    }

    /**
     * @return HasMany<EmployeeIdentity, $this>
     */
    public function identifications(): HasMany
    {
        return $this->hasMany(EmployeeIdentity::class);
    }

    /**
     * @return HasOne<EmployeeSalaryRevision, $this>
     */
    public function latestSalaryRevision(): HasOne
    {
        return $this->hasOne(EmployeeSalaryRevision::class)
            ->latestOfMany('effective_date');
    }

    /**
     * @return HasOne<EmployeeContract, $this>
     */
    public function latestContract(): HasOne
    {
        return $this->hasOne(EmployeeContract::class)
            ->latestOfMany('start_date');
    }
}
