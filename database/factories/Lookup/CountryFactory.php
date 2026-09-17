<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Models\Lookup\Country;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Country>
 */
#[UseModel(Country::class)]
class CountryFactory extends Factory
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
            'sort_order' => fake()->numberBetween(1, 100),
            'lang' => 'en',
            'is_active' => fake()->boolean(),
        ];
    }
}
