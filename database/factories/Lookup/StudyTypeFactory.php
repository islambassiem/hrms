<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Models\Lookup\StudyType;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudyType>
 */
class StudyTypeFactory extends Factory
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
