<?php

use App\Enums\VisaPayerEnum;
use App\Enums\VisaPaymentEnum;
use App\Enums\VisaStatusEnum;
use App\Http\Resources\Employee\VisaResource;
use App\Models\Request\Visa;

it('serializes the Visa fields required by the Employee request interface', function (): void {
    $visa = Visa::factory()->create([
        'end_date' => '2026-12-20',
        'for_year' => 2026,
        'payer' => VisaPayerEnum::COMPANY,
        'payment' => VisaPaymentEnum::PENDING,
        'start_date' => '2026-12-01',
        'status' => VisaStatusEnum::PENDING,
    ]);

    $resource = VisaResource::make($visa->load('employee'))->resolve();

    expect($resource)->toMatchArray([
        'end_date' => '2026-12-20',
        'for_year' => 2026,
        'id' => $visa->id,
        'payer' => VisaPayerEnum::COMPANY->value,
        'payment' => VisaPaymentEnum::PENDING->value,
        'start_date' => '2026-12-01',
        'status' => VisaStatusEnum::PENDING->value,
    ]);
});
