<?php

declare(strict_types=1);

namespace App\Models\Lookup;

use App\Concerns\UserStamp;
use Database\Factories\Lookup\DeductionFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name_en',
    'name_ar',
    'code',
    'sort_order',
    'created_by',
    'updated_by',
])]
#[Table('lookup_payroll_deductions')]
final class Deduction extends Model
{
    /** @use HasFactory<DeductionFactory> */
    use HasFactory;

    use UserStamp;
}
