<?php

declare(strict_types=1);

namespace App\Data\Request;

use App\Enums\FamilyVisitStatusEnum;
use Spatie\LaravelData\Data;

class FamilyVisitData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $employee_id,
        public string $number,
        public FamilyVisitStatusEnum $status
    ) {
        //
    }
}
