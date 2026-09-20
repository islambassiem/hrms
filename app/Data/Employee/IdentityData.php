<?php

declare(strict_types=1);

namespace App\Data\Employee;

use App\Concerns\Employee\IdentityValidationRules;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Data;

final class IdentityData extends Data
{
    use IdentityValidationRules;

    public function __construct(
        public int $employee_id,
        public int $identity_type_id,
        public string $identity_number,
        public ?string $place_of_issue = null,
        public ?CarbonImmutable $issue_date = null,
        public ?CarbonImmutable $expiry_date = null,
    ) {}
}
