<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Models\Lookup\FamilyRelationship;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<FamilyRelationship>
 */
class FamilyRelationshipFactory extends Factory
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
