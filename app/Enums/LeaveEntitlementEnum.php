<?php

declare(strict_types=1);

namespace App\Enums;

enum LeaveEntitlementEnum: string
{
    case ACTIVE = 'active';

    case CLOSED = 'closed';

    case EXPIRED = 'expired';
}
