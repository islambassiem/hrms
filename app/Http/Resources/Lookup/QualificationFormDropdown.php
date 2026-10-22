<?php

declare(strict_types=1);

namespace App\Http\Resources\Lookup;

use App\Models\Lookup\Country;
use App\Models\Lookup\EducationalSublevel;
use App\Models\Lookup\GpaType;
use App\Models\Lookup\IncludedSpecialization;
use App\Models\Lookup\Rating;
use App\Models\Lookup\ScientificDegree;
use App\Models\Lookup\Speciality;
use App\Models\Lookup\StudyType;

class QualificationFormDropdown
{
    /**
     * @return array<string, mixed>
     */
    public function dropdowns(): array
    {
        return [
            'countries' => IdNameResource::collection(Country::all())->resolve(),
            'educational_sublevels' => IdNameResource::collection(EducationalSublevel::all())->resolve(),
            'gpa_types' => IdNameResource::collection(GpaType::all())->resolve(),
            'included_specializations' => IdNameResource::collection(IncludedSpecialization::all())->resolve(),
            'ratings' => IdNameResource::collection(Rating::all())->resolve(),
            'scientific_degrees' => IdNameResource::collection(ScientificDegree::all())->resolve(),
            'specialities' => IdNameResource::collection(Speciality::all())->resolve(),
            'study_types' => IdNameResource::collection(StudyType::all())->resolve(),
        ];
    }
}
