<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Models\Lookup\Speciality;
use App\Models\Lookup\SpecialityCategory;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Speciality>
 */
class SpecialityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            ...LookupFactory::run(),
            'category_id' => SpecialityCategory::factory(),
        ];
    }
}
