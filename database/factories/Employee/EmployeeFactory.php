<?php

declare(strict_types=1);

namespace Database\Factories\Employee;

use App\Models\Employee\Employee;
use App\Models\Lookup\Category;
use App\Models\Lookup\Country;
use App\Models\Lookup\Department;
use App\Models\Lookup\Gender;
use App\Models\Lookup\MaritalStatus;
use App\Models\Lookup\Religion;
use App\Models\Lookup\SpecialNeed;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Employee>
 */
class EmployeeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'head_id' => null,
            'employee_code' => fake()->unique()->regexify('50[01][0-9]{3}'),

            'first_name_ar' => fake('ar_SA')->firstName(),
            'middle_name_ar' => fake()->randomElement([null, fake('ar_SA')->firstName()]),
            'third_name_ar' => fake()->randomElement([null, fake('ar_SA')->firstName()]),
            'last_name_ar' => fake('ar_SA')->lastName(),

            'first_name_en' => fake()->firstName(),
            'middle_name_en' => fake()->randomElement([null, fake()->firstName()]),
            'third_name_en' => fake()->randomElement([null, fake()->firstName()]),
            'last_name_en' => fake()->lastName(),

            'marital_status_id' => MaritalStatus::factory(),
            'religion_id' => Religion::factory(),
            'special_need_id' => SpecialNeed::factory(),

            'gender_id' => Gender::factory(),
            'category_id' => Category::factory(),
            'department_id' => Department::factory(),
            'nationality_id' => Country::factory(),
            'place_of_birth_id' => Country::factory(),

            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->numerify('5########'),

            'date_of_birth' => fake()->date(),
            'joining_date' => fake()->date(),
            'leaving_date' => fake()->date(),

            'home_telephone_number' => fake()->randomElement([null, fake()->phoneNumber()]),
            'home_country_identity' => fake()->randomElement([null, fake()->numerify('##########')]),
            'blood_type' => fake()->bloodGroup(),

            'is_active' => fake()->boolean(70),
        ];
    }
}
