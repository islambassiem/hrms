<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Models\Lookup\SpecialNeed;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SpecialNeed>
 */
class SpecialNeedFactory extends Factory
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
