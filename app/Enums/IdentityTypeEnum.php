<?php

declare(strict_types=1);

namespace App\Enums;

enum IdentityTypeEnum: int
{
    case NATIONAL_IDENTITY = 1;

    case PASSPORT = 2;

    case BORDERLINE_NUMBER = 3;
}
