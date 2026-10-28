<?php

declare(strict_types=1);

namespace App\Enums;

enum VisaStatusEnum: string
{
    case PENDING = 'pending';

    case PROCESSING = 'processing';

    case ISSUED = 'issued';
}
