<?php

declare(strict_types=1);

namespace Tests\Support;

use InvalidArgumentException;

final class DatabaseState
{
    public static function foreignKey(
        string $model,
        mixed $value = null,
        string $column = 'id',
    ): mixed {
        $value ??= PHP_INT_MAX;

        throw_if($model::query()->where($column, $value)->exists(), InvalidArgumentException::class, "The value [{$value}] already exists in {$model}.");

        return $value;
    }

    public static function unique(
        string $model,
        string $column,
        mixed $value,
    ): mixed {
        $model::factory()->create([
            $column => $value,
        ]);

        return $value;
    }
}
