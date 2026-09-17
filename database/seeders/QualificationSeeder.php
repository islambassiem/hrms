<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Employees\Employee;
use App\Models\Lookup\Country;
use App\Models\Lookup\EducationalSublevel;
use App\Models\Lookup\GpaType;
use App\Models\Lookup\IncludedSpecialization;
use App\Models\Lookup\Rating;
use App\Models\Lookup\ScientificDegree;
use App\Models\Lookup\Speciality;
use App\Models\Lookup\StudyType;
use App\Models\Qualifications\Qualification;
use Illuminate\Database\Seeder;

class QualificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeIds = Employee::query()->pluck('id');
        $specialityIds = Speciality::query()->pluck('id');
        $subLevelIds = EducationalSublevel::query()->pluck('id');
        $includedSpecialityIds = IncludedSpecialization::query()->pluck('id');
        $scientificDegreeIds = ScientificDegree::query()->pluck('id');
        $countryIds = Country::query()->pluck('id');
        $ratingIds = Rating::query()->pluck('id');
        $gpaTypeIds = GpaType::query()->pluck('id');
        $studyTypeIds = StudyType::query()->pluck('id');

        Qualification::factory(50)->create([
            'employee_id' => fn () => $employeeIds->random(),
            'major_id' => fn () => $specialityIds->random(),
            'minor_id' => fn () => $specialityIds->random(),
            'educational_sublevel_id' => fn () => $subLevelIds->random(),
            'included_specialty_id' => fn () => $includedSpecialityIds->random(),
            'scientific_degree_id' => fn () => $scientificDegreeIds->random(),
            'graduation_country_id' => fn () => $countryIds->random(),
            'rating_id' => fn () => $ratingIds->random(),
            'gpa_type_id' => fn () => $gpaTypeIds->random(),
            'study_type_id' => fn () => $studyTypeIds->random(),
        ]);
    }
}
