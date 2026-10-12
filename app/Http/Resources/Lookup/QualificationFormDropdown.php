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
            'countries' => IdNameResource::collection(Country::all()),
            'educational_sublevels' => IdNameResource::collection(EducationalSublevel::all()),
            'gpa_types' => IdNameResource::collection(GpaType::all()),
            'included_specializations' => IdNameResource::collection(IncludedSpecialization::all()),
            'ratings' => IdNameResource::collection(Rating::all()),
            'scientific_degrees' => IdNameResource::collection(ScientificDegree::all()),
            'specialities' => IdNameResource::collection(Speciality::all()),
            'study_types' => IdNameResource::collection(StudyType::all()),
        ];
    }
}
