<?php

declare(strict_types=1);

namespace App\Models\Lookup;

use App\Concerns\UserStamp;
use Database\Factories\Lookup\GenderFactory;
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
#[Table('lookup_genders')]
final class Gender extends Model
{
    /** @use HasFactory<GenderFactory> */
    use HasFactory;

    use UserStamp;
}
