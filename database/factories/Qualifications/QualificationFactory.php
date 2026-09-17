<?php

declare(strict_types=1);

namespace Database\Factories\Qualifications;

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
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Qualification>
 */
class QualificationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'employee_id' => Employee::factory(),
            'major_id' => Speciality::factory(),
            'minor_id' => Speciality::factory(),
            'educational_sublevel_id' => EducationalSublevel::factory(),
            'included_specialty_id' => IncludedSpecialization::factory(),
            'institution_name' => fake()->company(),
            'college_name' => fake()->company(),
            'scientific_degree_id' => ScientificDegree::factory(),
            'graduation_date' => fake()->date(),
            'graduation_country_id' => Country::factory(),
            'is_last_qualification' => fake()->boolean(),

            'rating_id' => Rating::factory(),
            'gpa' => fake()->randomFloat(2, 0, 4),
            'gpa_type_id' => GpaType::factory(),
            'study_type_id' => StudyType::factory(),
            'city' => fake()->city(),
            'is_authenticated' => fake()->boolean(),
        ];
    }
}
