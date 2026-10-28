<?php

declare(strict_types=1);

namespace App\Enums;

enum VisaPayerEnum: string
{
    case EMPLOYEE = 'employee';

    case COMPANY = 'company';
}
