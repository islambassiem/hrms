<?php

declare(strict_types=1);

namespace Database\Factories\Lookup;

use App\Models\Lookup\Category;
use App\Services\LookupFactory;
use Illuminate\Database\Eloquent\Factories\Attributes\UseModel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Category>
 */
#[UseModel(Category::class)]
class CategoryFactory extends Factory
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
