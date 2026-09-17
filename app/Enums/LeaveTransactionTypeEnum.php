<?php

declare(strict_types=1);

namespace App\Enums;

enum LeaveTransactionTypeEnum: string
{
    case ACCRUAL = 'accrual';

    case DEDUCTION = 'deduction';

    case MANUAL_ADJUSTMENT = 'manual_adjustment';

    case LEAVE_TAKEN = 'leave_taken';

    case CARRY_FORWARD = 'carry_forward';

    case CARRY_EXPIRES = 'carry_expiry';
}
