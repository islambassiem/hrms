<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Enums\DepartmentTypeEnum;
use App\Models\Lookup\Department;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Department>
 */
class DepartmentFactory extends Factory
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
            'type' => fake()->randomElement(DepartmentTypeEnum::cases()),
            'is_active' => fake()->boolean(),
            'parent_id' => null,
            'head_id' => null,
        ];
    }
}
