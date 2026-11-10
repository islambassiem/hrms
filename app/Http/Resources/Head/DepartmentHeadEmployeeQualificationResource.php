<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Http\Resources\Employee\QualificationAttachmentResource;
use App\Models\Qualifications\Qualification;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Qualification
 */
final class DepartmentHeadEmployeeQualificationResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var CarbonImmutable|null $graduationDate */
        $graduationDate = $this->graduation_date;

        return [
            'id' => $this->id,
            'major' => $this->major?->name,
            'minor' => $this->minor?->name,
            'educationalSublevel' => $this->educationalSublevel?->name,
            'includedSpecialty' => $this->includedSpecialty?->name,
            'institutionName' => $this->institution_name,
            'collegeName' => $this->college_name,
            'scientificDegree' => $this->scientificDegree?->name,
            'graduationDate' => $graduationDate?->toDateString(),
            'graduationCountry' => $this->graduationCountry?->name,
            'isLastQualification' => (bool) $this->is_last_qualification,
            'rating' => $this->rating?->name,
            'gpa' => $this->gpa,
            'gpaType' => $this->gpaType?->name,
            'studyType' => $this->studyType?->name,
            'city' => $this->city,
            'isAuthenticated' => (bool) $this->is_authenticated,
            'attachments' => QualificationAttachmentResource::collection(
                $this->getMedia(),
            )->resolve($request),
        ];
    }
}
