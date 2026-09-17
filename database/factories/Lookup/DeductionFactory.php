<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Models\Lookup\Deduction;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Deduction>
 */
class DeductionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return LookupFactory::run();
    }
}
