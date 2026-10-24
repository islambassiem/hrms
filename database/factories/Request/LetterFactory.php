<?php

declare(strict_types=1);

namespace Database\Factories\Request;

use App\Enums\LetterStatusEnum;
use App\Models\Employee\Employee;
use App\Models\Request\Letter;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Letter>
 */
class LetterFactory extends Factory
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
            'title' => fake()->sentence(),
            'description' => fake()->optional()->paragraph(),
            'notes' => fake()->optional()->paragraph(),
            'include_salary' => fake()->boolean(),
            'attested' => fake()->boolean(),
            'status' => fake()->randomElement(LetterStatusEnum::cases()),
        ];
    }
}
