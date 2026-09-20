<?php

declare(strict_types=1);

namespace App\Models\Lookup;

use App\Concerns\UserStamp;
use Database\Factories\Lookup\AppointmentTypeFactory;
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
#[Table('lookup_appointment_types')]
final class AppointmentType extends Model
{
    /** @use HasFactory<AppointmentTypeFactory> */
    use HasFactory;

    use UserStamp;
}
