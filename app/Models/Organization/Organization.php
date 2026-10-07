<?php

declare(strict_types=1);

namespace App\Models\Organization;

use App\Concerns\HasLocalizedName;
use App\Concerns\UserStamp;
use Database\Factories\Organization\OrganizationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'name_en',
    'name_ar',
    'id_number',
    'cr_number',
    'created_by',
    'updated_by',
])]
class Organization extends Model
{
    /** @use HasFactory<OrganizationFactory> */
    use HasFactory;

    use HasLocalizedName;
    use UserStamp;
}
