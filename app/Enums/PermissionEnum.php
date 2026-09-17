<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionEnum: string
{
    case PERSONAL_PAGE = 'view-personal-page';

    case HR_PAGE = 'view-hr-page';

    case HEAD_PAGE = 'view-head-page';
}
