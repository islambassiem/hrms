<?php

declare(strict_types=1);

namespace App\Enums;

enum DepartmentTypeEnum: string
{
    case DEPARTMENT = 'department';
    case COLLEGE = 'college';
    case ENTITY = 'entity';
}
