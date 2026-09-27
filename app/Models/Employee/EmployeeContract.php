<?php

declare(strict_types=1);

namespace App\Models\Employee;

use App\Concerns\UserStamp;
use App\Enums\ContractTypeEnum;
use Database\Factories\Employee\EmployeeContractFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'salary_revision_id',
    'address_id',
    'start_date',
    'duration',
    'probation_period',
    'notice_period',
    'type',
    'end_date',
    'created_by',
    'updated_by',
])]
class EmployeeContract extends Model
{
    /** @use HasFactory<EmployeeContractFactory> */
    use HasFactory;

    use UserStamp;

    protected function casts()
    {
        return [
            'start_date' => 'immutable_date',
            'end_date' => 'immutable_date',
            'type' => ContractTypeEnum::class,
        ];
    }
}
