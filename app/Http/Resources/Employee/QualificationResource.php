<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Http\Resources\Lookup\IdNameResource;
use App\Models\Qualifications\Qualification;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Qualification
 */
class QualificationResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        /** @var CarbonImmutable $graduationDate */
        $graduationDate = $this->graduation_date;

        return [
            'id' => $this->id,
            'employee_code' => $this->employee_id,
            'major' => IdNameResource::make($this->whenLoaded('major')),
            'minor' => IdNameResource::make($this->whenLoaded('minor')),
            'educational_sublevel' => IdNameResource::make($this->whenLoaded('educationalSublevel')),
            'institution_name' => $this->institution_name,
            'college_name' => $this->college_name,
            'scientific_degree' => IdNameResource::make($this->whenLoaded('scientificDegree')),
            'graduation_date' => $graduationDate->toDateString(),
            'graduation_country' => IdNameResource::make($this->whenLoaded('graduationCountry')),
            'is_last_qualification' => $this->is_last_qualification,
            'rating' => IdNameResource::make($this->whenLoaded('rating')),
            'gpa' => $this->gpa,
            'gpa_type' => IdNameResource::make($this->whenLoaded('gpaType')),
            'study_type' => IdNameResource::make($this->whenLoaded('studyType')),
            'city' => $this->city,
            'is_authenticated' => $this->is_authenticated,
            'created_by' => IdNameResource::make($this->whenLoaded('createdBy')),
            'updated_by' => IdNameResource::make($this->whenLoaded('updatedBy')),
        ];
    }
}
