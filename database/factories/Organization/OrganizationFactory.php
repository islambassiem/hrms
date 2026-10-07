<?php

declare(strict_types=1);

namespace Database\Factories\Organization;

use App\Models\Organization\Organization;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Organization>
 */
class OrganizationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name_en' => fake()->company(),
            'name_ar' => fake('ar_SA')->company(),
            'id_number' => fake()->unique()->numerify('##########'),
            'cr_number' => fake()->unique()->numerify('##########'),
        ];
    }
}
