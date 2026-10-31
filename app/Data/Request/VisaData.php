<?php

declare(strict_types=1);

namespace App\Data\Request;

use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
use App\Enums\VisaStatusEnum;
use Carbon\CarbonImmutable;
use Spatie\LaravelData\Attributes\WithCast;
use Spatie\LaravelData\Casts\DateTimeInterfaceCast;
use Spatie\LaravelData\Data;

class VisaData extends Data
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $employee_id,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d')]
        public CarbonImmutable $start_date,
        #[WithCast(DateTimeInterfaceCast::class, 'Y-m-d')]
        public CarbonImmutable $end_date,
        public int $for_year,
        public ?VisaStatusEnum $status,
        public ?VisaPaymentEnum $payment,
        public ?VisaPayerEnum $payer
    ) {
        //
    }
}
