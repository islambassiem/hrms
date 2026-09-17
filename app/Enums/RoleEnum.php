<?php

declare(strict_types=1);

namespace App\Enums;

enum RoleEnum: string
{
    case DEPARTMENT_HEAD = 'department_head';

    case HR_PERSONNEL = 'hr_personnel';
}
