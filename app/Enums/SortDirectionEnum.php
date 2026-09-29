<?php

declare(strict_types=1);

namespace App\Enums;

enum SortDirectionEnum: string
{
    case ASCENDING = 'asc';

    case DESCENDING = 'desc';
}
