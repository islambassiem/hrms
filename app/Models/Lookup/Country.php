<?php

declare(strict_types=1);

namespace App\Models\Lookup;

use App\Concerns\UserStamp;
use Database\Factories\Lookup\CountryFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name_en',
    'name_ar',
    'code',
    'sort_order',
    'lang',
    'is_active',
    'created_by',
    'updated_by',
])]
#[Table('lookup_countries')]
class Country extends Model
{
    /** @use HasFactory<CountryFactory> */
    use HasFactory;

    use UserStamp;
}
