<?php

declare(strict_types=1);

namespace App\Enums;

enum PermissionEnum: string
{
    case HR_PAGE = 'view-hr-page';

    case HEAD_PAGE = 'view-head-page';
}
