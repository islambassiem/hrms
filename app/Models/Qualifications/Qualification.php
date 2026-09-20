<?php

declare(strict_types=1);

namespace App\Models\Qualifications;

use App\Concerns\UserStamp;
use Database\Factories\Qualifications\QualificationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

#[Fillable([
    'emplyee_id',
    'major_id',
    'minor_id',
    'educational_sub_level_id',
    'included_specialty_id',
    'institution_name',
    'college_name',
    'scientific_degree_id',
    'graduation_date',
    'graduation_country_id',
    'is_last_qualification',
    'rating_id',
    'gpa',
    'gpa_type_id',
    'study_type_id',
    'city',
    'is_authenticated',
    'created_by',
    'updated_by',
])]
final class Qualification extends Model
{
    /** @use HasFactory<QualificationFactory> */
    use HasFactory;

    use UserStamp;
}
