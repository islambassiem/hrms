<?php

declare(strict_types=1);

namespace App\Data\Request\Letter;

use App\Enums\LetterStatusEnum;
use Spatie\LaravelData\Data;

class LetterData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $employee_id,
        public string $title,
        public ?string $description,
        public ?string $notes,
        public ?bool $include_salary,
        public ?bool $attested,
        public ?LetterStatusEnum $status,
    ) {
        //
    }
}
