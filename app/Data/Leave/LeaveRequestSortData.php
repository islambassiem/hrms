<?php

namespace App\Data\Leave;

class LeaveRequestSortData
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $field = 'created_at',
        public string $order = 'desc',
    )
    {
        //
    }
}
