<?php

declare(strict_types=1);

namespace App\Models\Leave;

use App\Concerns\UserStamp;
use Database\Factories\Leave\LeavePeriodFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name_en',
    'name_ar',
    'code',
    'type',
    'start_date',
    'end_date',
    'is_closed',
    'created_by',
    'updated_by',
])]
class LeavePeriod extends Model
{
    /** @use HasFactory<LeavePeriodFactory> */
    use HasFactory;

    use UserStamp;
}
