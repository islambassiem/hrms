<?php

declare(strict_types=1);

namespace App\Enums;

enum VisaPaymentEnum: string
{
    case PENDING = 'pending';

    case PROCESSING = 'processing';

    case PAID = 'paid';
}
