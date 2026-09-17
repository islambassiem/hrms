<?php

declare(strict_types=1);

namespace App\Models\Leave;

use Database\Factories\Leave\EmployeeSickLeaveCycleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'employee_id',
    'start_date',
    'end_date',
    'used_days',
])]
#[Table('leave_employee_sick_cycles')]
class EmployeeSickLeaveCycle extends Model
{
    /** @use HasFactory<EmployeeSickLeaveCycleFactory> */
    use HasFactory;
}
