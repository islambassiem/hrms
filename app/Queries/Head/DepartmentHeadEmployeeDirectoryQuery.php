<?php

declare(strict_types=1);

namespace App\Queries\Head;

use App\Data\Head\DepartmentHeadEmployeeFiltersData;
use App\Models\Employee\Employee;
use App\Models\Lookup\Gender;
use Illuminate\Database\Eloquent\Builder;

final class DepartmentHeadEmployeeDirectoryQuery
{
    /**
     * @return Builder<Employee>
     */
    public function run(
        Employee $departmentHead,
        DepartmentHeadEmployeeFiltersData $filters,
    ): Builder {
        $query = Employee::query()
            ->with([
                'gender:id,name_en,name_ar',
                'user:id,email',
                'latestQualification',
                'latestQualification.major:id,name_en,name_ar',
                'latestQualification.educationalSublevel:id,name_en,name_ar',
                'latestQualification.scientificDegree:id,name_en,name_ar',
            ])
            ->where('head_id', $departmentHead->id)
            ->where('is_active', true)
            ->when(
                $filters->genderId,
                fn (Builder $employees, int $genderId): Builder => $employees->where('gender_id', $genderId),
            )
            ->orderBy('employee_code')
            ->orderBy('id');

        $search = trim($filters->search ?? '');
        $searchTerms = preg_split('/\s+/u', $search, -1, PREG_SPLIT_NO_EMPTY);

        foreach ($searchTerms === false ? [] : $searchTerms as $searchTerm) {
            $pattern = "%{$searchTerm}%";

            $query->where(function (Builder $employees) use ($pattern): void {
                $employees
                    ->where('first_name_en', 'like', $pattern)
                    ->orWhere('middle_name_en', 'like', $pattern)
                    ->orWhere('third_name_en', 'like', $pattern)
                    ->orWhere('last_name_en', 'like', $pattern)
                    ->orWhere('first_name_ar', 'like', $pattern)
                    ->orWhere('middle_name_ar', 'like', $pattern)
                    ->orWhere('third_name_ar', 'like', $pattern)
                    ->orWhere('last_name_ar', 'like', $pattern)
                    ->orWhereHas('user', fn (Builder $users): Builder => $users
                        ->where('email', 'like', $pattern));
            });
        }

        return $query;
    }

    /**
     * @return Builder<Gender>
     */
    public function genders(): Builder
    {
        return Gender::query()
            ->whereIn('name_en', ['Male', 'Female'])
            ->orderBy('sort_order')
            ->orderBy('id');
    }
}
