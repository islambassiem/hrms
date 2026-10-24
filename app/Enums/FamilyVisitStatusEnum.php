<?php

declare(strict_types=1);

namespace App\Enums;

enum FamilyVisitStatusEnum: string
{
    case PENDING = 'pending';

    case ATTESTED = 'attested';
}
