<?php

declare(strict_types=1);

namespace App\Enums;

enum YearTypeEnum: string
{
    case ACADEMIC_YEAR = 'academic_year';

    case CALENDAR_YEAR = 'calendar_year';
}
