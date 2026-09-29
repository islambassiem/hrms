<?php

declare(strict_types=1);

namespace App\Data\Leave;

use App\Enums\SortDirectionEnum;

class LeaveRequestSortData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $field = 'created_at',
        public SortDirectionEnum $order = SortDirectionEnum::DESCENDING,
    ) {
        //
    }
}
