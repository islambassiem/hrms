<?php

declare(strict_types=1);

namespace App\Data\Payroll;

use Spatie\LaravelData\Data;

class EmployeeBankData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public ?int $employee_id,
        public ?int $bank_id,
        public ?string $iban,
    ) {}
}
