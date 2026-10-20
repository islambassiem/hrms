<?php

declare(strict_types=1);

namespace App\Models\Qualifications;

use App\Concerns\UserStamp;
use App\Models\Lookup\Country;
use App\Models\Lookup\EducationalSublevel;
use App\Models\Lookup\GpaType;
use App\Models\Lookup\IncludedSpecialization;
use App\Models\Lookup\Rating;
use App\Models\Lookup\ScientificDegree;
use App\Models\Lookup\Speciality;
use App\Models\Lookup\StudyType;
use App\Policies\Employee\QualificationPolicy;
use Database\Factories\Qualifications\QualificationFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

#[Fillable([
    'employee_id',
    'educational_sublevel_id',
    'major_id',
    'minor_id',
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

#[UsePolicy(QualificationPolicy::class)]
final class Qualification extends Model implements HasMedia
{
    /** @use HasFactory<QualificationFactory> */
    use HasFactory;

    use InteractsWithMedia;
    use UserStamp;

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [
            'graduation_date' => 'immutable_date',
            'is_last_qualification' => 'boolean',
            'is_authenticated' => 'boolean',
        ];
    }

    /**
     * @return BelongsTo<EducationalSublevel, $this>
     */
    public function educationalSublevel(): BelongsTo
    {
        return $this->belongsTo(EducationalSublevel::class);
    }

    /**
     * @return BelongsTo<Speciality, $this>
     */
    public function minor(): BelongsTo
    {
        return $this->belongsTo(Speciality::class, 'minor_id');
    }

    /**
     * @return BelongsTo<Speciality, $this>
     */
    public function major(): BelongsTo
    {
        return $this->belongsTo(Speciality::class, 'major_id');
    }

    /**
     * @return BelongsTo<IncludedSpecialization, $this>
     */
    public function includedSpecialty(): BelongsTo
    {
        return $this->belongsTo(IncludedSpecialization::class, 'included_specialty_id');
    }

    /**
     * @return BelongsTo<ScientificDegree, $this>
     */
    public function scientificDegree(): BelongsTo
    {
        return $this->belongsTo(ScientificDegree::class, 'scientific_degree_id');
    }

    /**
     * @return BelongsTo<Country, $this>
     */
    public function graduationCountry(): BelongsTo
    {
        return $this->belongsTo(Country::class, 'graduation_country_id');
    }

    /**
     * @return BelongsTo<Rating, $this>
     */
    public function rating(): BelongsTo
    {
        return $this->belongsTo(Rating::class, 'rating_id');
    }

    /**
     * @return BelongsTo<GpaType, $this>
     */
    public function gpaType(): BelongsTo
    {
        return $this->belongsTo(GpaType::class, 'gpa_type_id');
    }

    /**
     * @return BelongsTo<StudyType, $this>
     */
    public function studyType(): BelongsTo
    {
        return $this->belongsTo(StudyType::class, 'study_type_id');
    }
}
