<?php

declare(strict_types=1);

namespace Database\Factories\Request;

use App\Enums\FamilyVisitStatusEnum;
use App\Models\Employee\Employee;
use App\Models\Request\FamilyVisit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FamilyVisit>
 */
class FamilyVisitFactory extends Factory
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
            'number' => fake()->numerify('########'),
            'status' => fake()->randomElement(FamilyVisitStatusEnum::cases()),
        ];
    }
}
