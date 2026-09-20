<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Concerns\UserStamp;
use Database\Factories\Leave\SickLeaveRuleFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'no_of_days',
    'pay_rate',
    'effective_from',
    'effective_to',
    'created_by',
    'updated_by',
])]
#[Table('leave_sick_rules')]
final class SickLeaveRule extends Model
{
    /** @use HasFactory<SickLeaveRuleFactory> */
    use HasFactory;

    use UserStamp;
}
