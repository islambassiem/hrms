<?php

declare(strict_types=1);

namespace App\Enums;

enum WorkflowActionEnum: string
{
    case PENDING = 'pending';

    case APPROVED = 'approved';

    case REJECTED = 'rejected';

    case CANCELLED = 'cancelled';
}
