<?php

declare(strict_types=1);

namespace App\Enums;

enum AccrualFrequencyEnum: string
{
    case MONTHLY = 'monthly';

    case ANNUALY = 'annualy';
}
