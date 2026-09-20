<?php

declare(strict_types=1);

namespace App\Services;

final class LookupFactory
{
    /**
     * @return array{code: int, "name_ar": string, "name_en": string}
     */
    public static function run(): array
    {
        return [
            'name_en' => fake()->name(),
            'name_ar' => fake('ar_SA')->name(),
            'code' => fake()->unique()->randomNumber(2),
        ];
    }
}
