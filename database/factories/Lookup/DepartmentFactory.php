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
        $types = DepartmentTypeEnum::cases();

        return [
            ...LookupFactory::run(),
            'type' => $types[array_rand($types)],
            'is_active' => (bool) random_int(0, 1),
            'parent_id' => null,
            'head_id' => null,
        ];
    }
}
