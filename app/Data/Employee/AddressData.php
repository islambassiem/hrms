<?php

declare(strict_types=1);

namespace App\Data\Employee;

use Spatie\LaravelData\Data;

final class AddressData extends Data
{
    public function __construct(
        public ?int $employee_id,
        public ?string $short_address,
        public ?string $building_number = null,
        public ?string $street = null,
        public ?string $secondary_number = null,
        public ?string $district = null,
        public ?string $postal_code = null,
        public ?string $city = null,
    ) {}
}
