<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Models\Employee\Employee;
use App\Models\Lookup\Gender;
use App\Models\Qualifications\Qualification;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @mixin Employee
 */
final class DepartmentHeadDirectoryEmployeeResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var Gender|null $gender */
        $gender = $this->gender;

        /** @var Qualification|null $qualification */
        $qualification = $this->latestQualification;

        /** @var CarbonImmutable|null $graduationDate */
        $graduationDate = $qualification?->graduation_date;

        return [
            'id' => $this->id,
            'employeeCode' => $this->employee_code,
            'name' => Str::squish($this->name),
            'image' => $this->image,
            'gender' => $gender instanceof Gender ? [
                'id' => $gender->id,
                'name' => $gender->name,
            ] : null,
            'officialEmail' => $this->user?->email,
            'latestQualification' => $qualification instanceof Qualification ? [
                'scientificDegree' => $qualification->scientificDegree?->name,
                'educationalSublevel' => $qualification->educationalSublevel?->name,
                'major' => $qualification->major?->name,
                'graduationDate' => $graduationDate?->toDateString(),
            ] : null,
        ];
    }
}
