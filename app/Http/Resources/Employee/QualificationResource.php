<?php

declare(strict_types=1);

namespace App\Http\Resources\Employee;

use App\Http\Resources\Lookup\IdNameResource;
use App\Models\Qualifications\Qualification;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Model;
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
        /** @var CarbonImmutable|null $graduationDate */
        $graduationDate = $this->graduation_date;

        return [
            'id' => $this->id,
            'employee_code' => $this->employee_id,
            'major' => $this->lookup('major', $request),
            'minor' => $this->lookup('minor', $request),
            'educational_sublevel' => $this->lookup('educationalSublevel', $request),
            'included_specialty' => $this->lookup('includedSpecialty', $request),
            'institution_name' => $this->institution_name,
            'college_name' => $this->college_name,
            'scientific_degree' => $this->lookup('scientificDegree', $request),
            'graduation_date' => $graduationDate?->toDateString(),
            'graduation_country' => $this->lookup('graduationCountry', $request),
            'is_last_qualification' => $this->is_last_qualification,
            'rating' => $this->lookup('rating', $request),
            'gpa' => $this->gpa,
            'gpa_type' => $this->lookup('gpaType', $request),
            'study_type' => $this->lookup('studyType', $request),
            'city' => $this->city,
            'is_authenticated' => $this->is_authenticated,
            'created_by' => $this->lookup('creator', $request),
            'updated_by' => $this->lookup('editor', $request),
        ];
    }

    /**
     * @return array<string, mixed>|null
     */
    private function lookup(string $relationship, Request $request): ?array
    {
        if (! $this->relationLoaded($relationship)) {
            return null;
        }

        $lookup = $this->getRelation($relationship);

        return $lookup instanceof Model
            ? IdNameResource::make($lookup)->toArray($request)
            : null;
    }
}
