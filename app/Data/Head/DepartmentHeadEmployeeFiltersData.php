<?php

declare(strict_types=1);

namespace App\Data\Head;

use Spatie\LaravelData\Data;

final class DepartmentHeadEmployeeFiltersData extends Data
{
    public function __construct(
        public ?string $search = null,
        public ?int $genderId = null,
    ) {}
}
