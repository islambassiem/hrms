<?php

declare(strict_types=1);

namespace App\Http\Resources\Head;

use App\Models\Employee\Employee;
use App\Models\Employee\EmployeeJobTitle;
use App\Models\Lookup\Department;
use App\Models\Lookup\Gender;
use App\Models\Lookup\JobTitle;
use Carbon\CarbonImmutable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

/**
 * @mixin Employee
 */
final class DepartmentHeadEmployeeDetailsResource extends JsonResource
{
    /** @return array<string, mixed> */
    public function toArray(Request $request): array
    {
        /** @var Gender|null $gender */
        $gender = $this->gender;

        /** @var Department|null $department */
        $department = $this->department;

        /** @var EmployeeJobTitle|null $currentJobTitle */
        $currentJobTitle = $this->latestCurrentJobTitle;

        /** @var JobTitle|null $jobTitle */
        $jobTitle = $currentJobTitle?->jobTitle;

        /** @var CarbonImmutable|null $joiningDate */
        $joiningDate = $this->joining_date;

        /** @var CarbonImmutable|null $positionStartDate */
        $positionStartDate = $currentJobTitle?->start_date;

        return [
            'id' => $this->id,
            'employeeCode' => $this->employee_code,
            'name' => Str::squish($this->name),
            'image' => $this->image,
            'gender' => $gender?->name,
            'officialEmail' => $this->user?->email,
            'department' => $department?->name,
            'isActive' => (bool) $this->is_active,
            'joiningDate' => $joiningDate?->toDateString(),
            'currentPosition' => $jobTitle instanceof JobTitle ? [
                'title' => $jobTitle->name,
                'startDate' => $positionStartDate?->toDateString(),
            ] : null,
        ];
    }
}
